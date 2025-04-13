<?php

// app/Models/Food.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price'
    ];
}
