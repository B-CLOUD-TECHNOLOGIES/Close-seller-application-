<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //

    protected $guarded = [];

    protected $table = "orders";


    protected $casts = [
        'payment_data' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function orderTrackings()
{
    return $this->hasMany(OrderTracking::class, 'order_id', 'id');
}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
