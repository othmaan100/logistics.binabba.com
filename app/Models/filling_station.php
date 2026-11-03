<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class filling_station extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
    ];

       //Table Name
       //protected $table = 'fuel_debts';

       //primary key
       public $primaryKey ='company_id';
       //TimeStamps
        public $timeStamps = false;
}
