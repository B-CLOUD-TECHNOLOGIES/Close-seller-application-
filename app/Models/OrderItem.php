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
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}
