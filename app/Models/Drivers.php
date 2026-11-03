<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Truck;

class Drivers extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id_no','driver_name','driver_phone', 'driver_address','driver_image',
    ];


    //Table Name
    protected $table = 'tbl_drivers';

    //primary key
    public $primaryKey ='driver_id';
    //TimeStamps
    public $timeStamps = true;

    public function myTruck()
    {
        return $this->hasOne('App\Models\Truck', 'driver_id_no', 'driver_id_no');
        #return $this->hasOne('App\Truck');
    } 

    public function myTasks()
    {
        return $this->hasMany('App\Models\Good', 'driver_id');
        
    } 
    public function truck() { 
        return $this->hasOne(Truck::class, 'driver_id_no', 'driver_id_no');
     }

}
