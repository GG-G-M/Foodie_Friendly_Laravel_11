<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'riderID',
        'total_amount',
        'delivery_address',
        'status',
        'order_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'riderID');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id'); // Changed from 'orderID' to 'order_id'
    }
}