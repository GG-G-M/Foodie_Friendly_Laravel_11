<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'license_code',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'riderID');
    }
}