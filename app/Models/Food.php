<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = [
        'name',
        'category',
        'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }
}