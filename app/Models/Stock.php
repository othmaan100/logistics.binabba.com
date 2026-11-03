<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id','stock','quantity', 'description',
    ];

       //Table Name
       protected $table = 'stock';

       
}
