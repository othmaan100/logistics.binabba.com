<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsData extends Model
{
    protected $table = 'gps_data';

    // created_at is filled by the database default; there is no updated_at column
    public $timestamps = false;

    protected $fillable = [
        'truck_id', 'latitude', 'longitude', 'altitude', 'speed', 'course',
        'direction', 'satellites', 'hdop', 'gps_date', 'gps_time',
    ];
}
