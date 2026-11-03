<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    use HasFactory;
    //Table Name
    protected $table = 'goodstypes';

    //primary key
    public $primaryKey ='id'; 
    //TimeStamps
    public $timeStamps = true;
}
