<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name','client_phone', 'client_address',
    ];


    //Table Name
    protected $table = 'tbl_clients';

    //primary key
    public $primaryKey ='id';
    //TimeStamps
    public $timeStamps = true;

    public function myGood()
    {
        return $this->hasMany('App\Models\Good', 'client_id');
        
    } 

     public function myPayments()
    {
        return $this->hasMany('App\Models\Payment');
        #return $this->hasOne('App\Truck');
    }
}
