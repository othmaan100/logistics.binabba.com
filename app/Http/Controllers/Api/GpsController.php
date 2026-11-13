<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GpsData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GpsController extends Controller
{
    // Shorter names trackers often send => our column names
    private const ALIASES = [
        'lat' => 'latitude', 'lng' => 'longitude', 'lon' => 'longitude', 'long' => 'longitude',
        'alt' => 'altitude', 'heading' => 'course', 'sats' => 'satellites', 'satellite' => 'satellites',
        'date' => 'gps_date', 'time' => 'gps_time',
    ];

    // The gps_data columns a reading can fill, in the order the reply lists them
    private const FIELDS = [
        'truck_id', 'latitude', 'longitude', 'altitude', 'speed', 'course',
        'direction', 'satellites', 'hdop', 'gps_date', 'gps_time',
    ];

    private const COMPASS =['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];

    /**
     * Store one reading posted by a truck's GPS tracker.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $this->normalise($request->all());

        // Validator::make rather than $request->validate(), so devices that don't
        // send "Accept: application/json" still get JSON errors instead of a redirect
        $validator = Validator::make($input, [
            'truck_id'   => 'required|string|max:50',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
            'altitude'   => 'nullable|numeric',
            'speed'      => 'nullable|numeric|min:0',
            'course'     => 'nullable|numeric|between:0,360',
            'direction'  => 'nullable|string|max:10',
            'satellites' => 'nullable|integer|min:0|max:99',
            'hdop'       => 'nullable|numeric|min:0',
            'gps_date'   => 'nullable|date_format:Y-m-d',
            'gps_time'   => 'nullable|date_format:H:i:s',
        ], [
            'gps_date.date_format' => 'The gps date must be a date such as 2026-11-13, 13/11/2026 or 131126 (DDMMYY).',
            'gps_time.date_format' => 'The gps time must be a time such as 10:15:30, 10:15 or 101530 (HHMMSS).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Fill in what the tracker didn't send
        if (empty($data['direction']) && isset($data['course'])) {
            $data['direction'] = self::COMPASS[(int) round(fmod((float) $data['course'], 360) / 22.5) % 16];
        }
        $now = now();
        $data['gps_date'] ??= $now->format('Y-m-d');
        $data['gps_time'] ??= $now->format('H:i:s');

        $reading = GpsData::create($data);

        // Every field, in a fixed order, null where the tracker sent nothing
        $stored = [];
        foreach (self::FIELDS as $field) {
            $stored[$field] = $data[$field] ?? null;
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged successfully',
            'id'      => $reading->id,
            'data'    => $stored,
        ], 200);
    }

    /**
     * Accept the formats GPS modules and Arduino libraries commonly produce.
     */
    private function normalise(array $input): array
    {
        foreach (self::ALIASES as $alias => $field) {
            if (!array_key_exists($field, $input) && array_key_exists($alias, $input)) {
                $input[$field] = $input[$alias];
            }
        }
        $input = array_intersect_key($input, array_flip(self::FIELDS));

        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
            }
            // Empty values and "unknown" markers count as not sent
            $input[$key] = ($value === '' || (is_string($value) && in_array(strtolower($value), ['null', 'nan', 'n/a', '-'], true))) ? null : $value;
        }

        if (isset($input['truck_id']) && is_numeric($input['truck_id'])) {
            $input['truck_id'] = (string) $input['truck_id'];
        }
        if (isset($input['satellites']) && is_numeric($input['satellites'])) {
            $input['satellites'] = (int) $input['satellites'];
        }
        if (isset($input['direction']) && is_string($input['direction'])) {
            $input['direction'] = strtoupper($input['direction']);
        }

        $input['gps_date'] = $this->parseDate($input['gps_date'] ?? null);
        $input['gps_time'] = $this->parseTime($input['gps_time'] ?? null);

        return $input;
    }

    private function parseDate(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }
        $value = (string) $value;

        $formats = [
            '/^\d{4}-\d{1,2}-\d{1,2}$/'   => 'Y-n-j',  // 2026-11-13
            '/^\d{1,2}\/\d{1,2}\/\d{4}$/' => 'j/n/Y',  // 13/11/2026 (day first, as in Nigeria)
            '/^\d{1,2}-\d{1,2}-\d{4}$/'   => 'j-n-Y',  // 13-11-2026
            '/^\d{1,2}\.\d{1,2}\.\d{4}$/' => 'j.n.Y',  // 13.11.2026
            '/^\d{8}$/'                   => 'Ymd',    // 20261113
            '/^\d{6}$/'                   => 'dmy',    // 131126, the NMEA / TinyGPS date
        ];
        foreach ($formats as $pattern => $format) {
            if (preg_match($pattern, $value)) {
                $date = \DateTime::createFromFormat('!' . $format, $value);
                $errors = \DateTime::getLastErrors();
                // PHP rolls impossible dates over (31/02 -> 03/03) with a warning; treat those as invalid
                $clean = !$errors || ($errors['warning_count'] === 0 && $errors['error_count'] === 0);

                return $date && $clean ? $date->format('Y-m-d') : $value;
            }
        }

        return $value; // left as sent, so validation reports it
    }

    private function parseTime(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }
        $value = (string) $value;

        // 10:15:30, 10:15:30.00, 10:15 and 9:05:07
        if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?(?:\.\d+)?$/', $value, $m)) {
            return $this->time($m[1], $m[2], $m[3] ?? 0) ?? $value;
        }
        // 101530 (HHMMSS) and 10153000 (HHMMSScc, TinyGPS's raw time); 6-digit numbers may lose a leading zero (91530)
        if (preg_match('/^\d{5,8}$/', $value)) {
            $digits = strlen($value) >= 7 ? str_pad($value, 8, '0', STR_PAD_LEFT) : str_pad($value, 6, '0', STR_PAD_LEFT);
            return $this->time(substr($digits, 0, 2), substr($digits, 2, 2), substr($digits, 4, 2)) ?? $value;
        }

        return $value;
    }

    private function time(string|int $h, string|int $m, string|int $s): ?string
    {
        [$h, $m, $s] = [(int) $h, (int) $m, (int) $s];

        return $h < 24 && $m < 60 && $s < 60 ? sprintf('%02d:%02d:%02d', $h, $m, $s) : null;
    }
}
