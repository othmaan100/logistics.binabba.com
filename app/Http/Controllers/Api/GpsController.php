<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GpsData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class GpsController extends Controller
{
    /**
     * Store one reading posted by a truck's GPS tracker.
     */
    public function store(Request $request): JsonResponse
    {
        // Validator::make rather than $request->validate(), so devices that don't
        // send "Accept: application/json" still get JSON errors instead of a redirect
        $validator = Validator::make($request->all(), [
            'truck_id'   => 'required|string|max:50',
            'latitude'   => 'required|numeric|between:-90,90',
            'longitude'  => 'required|numeric|between:-180,180',
            'altitude'   => 'nullable|numeric',
            'speed'      => 'nullable|numeric|min:0',
            'course'     => 'nullable|numeric|between:0,360',
            'direction'  => 'nullable|string|max:10',
            'satellites' => 'nullable|integer|min:0',
            'hdop'       => 'nullable|numeric|min:0',
            'gps_date'   => 'nullable|date',
            'gps_time'   => 'nullable|date_format:H:i:s,H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if (!empty($data['gps_date'])) {
            $data['gps_date'] = Carbon::parse($data['gps_date'])->format('Y-m-d');
        }
        if (!empty($data['gps_time'])) {
            $data['gps_time'] = Carbon::parse($data['gps_time'])->format('H:i:s');
        }

        $reading = GpsData::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Logged successfully',
            'id'      => $reading->id,
        ], 200);
    }
}
