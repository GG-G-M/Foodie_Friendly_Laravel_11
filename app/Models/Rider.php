<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'license_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}