<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $fillable = [
        'truck_model','plate_number','driver_id_no',
    ];

  
     public function myDriver()
    {
        return $this->belongsTo('App\Models\Drivers', 'driver_id_no', 'driver_id_no');
    }  
    public function myGood()
    {
        return $this->hasMany('App\Models\Good');
        #return $this->hasOne('App\Truck');
    } 
}
