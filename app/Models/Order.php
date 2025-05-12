<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rider_id',
        'total_amount', // Added
        'delivery_address',
        'payment_method',
        'delivery_fee',
        'status',
        'payment_status', // Added
        'order_date',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}