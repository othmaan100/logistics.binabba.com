<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TruckLocationController extends Controller
{
    /**
     * Truck location page for the admin area.
     */
    public function admin($id): View
    {
        return $this->show($id, 'layouts.admin', route('admin-trucks.index'));
    }

    /**
     * Truck location page for the staff (secretary) area.
     */
    public function staff($id): View
    {
        return $this->show($id, 'layouts.staff', route('trucks.index'));
    }

    private function show($id, string $layout, string $backUrl): View
    {
        $truck = DB::table('trucks')
            ->leftJoin('tbl_drivers', 'tbl_drivers.driver_id_no', '=', 'trucks.driver_id_no')
            ->select('trucks.*', 'tbl_drivers.driver_name', 'tbl_drivers.driver_phone')
            ->where('trucks.id', $id)
            ->first();

        abort_if(!$truck, 404);

        // gps_data.truck_id holds the truck id; accept the plate number as well
        $readings = DB::table('gps_data')
            ->where(function ($q) use ($truck) {
                $q->where('truck_id', (string) $truck->id)
                  ->orWhere('truck_id', $truck->plate_number);
            })
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderByDesc('gps_date')
            ->orderByDesc('gps_time')
            ->orderByDesc('id')
            ->limit(50)
            ->get()
            ->each(function ($r) {
                $r->recorded_at = $r->gps_date
                    ? Carbon::parse(trim($r->gps_date . ' ' . ($r->gps_time ?? '00:00:00')))
                    : Carbon::parse($r->created_at);
            });

        $latest = $readings->first();

        return view('trucks.location', compact('truck', 'readings', 'latest', 'layout', 'backUrl'));
    }
}
