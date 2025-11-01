<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $guarded = [];

    protected $table = "order_items";


    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id', 'id');
    }
    public function tracking()
    {
        return $this->hasMany(OrderTracking::class, 'product_id', 'product_id')
                    ->whereColumn('order_id', 'order_id')
                    ->latest();
    }
}
