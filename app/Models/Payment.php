<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id_no','payment_amount','payment_deposit', 
    ];


    //Table Name
    protected $table = 'tbl_payment';

    //primary key
    public $primaryKey ='payment_id';
    //TimeStamps
    public $timeStamps = true;

    public function client()
    {
        return $this->hasOne('App\Models\client');
    }
}
