<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        '	good_id','expenses_cost','expenses_reason', 'expenses_date',
    ];

       //Table Name
       protected $table = 'expenses';

       //primary key
       public $primaryKey ='expenses_id';
       //TimeStamps
        public $timeStamps = true;
}
