<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $guarded = [];
    protected $table = "cart_items";

    protected $casts = [
        'attributes' => 'array',
    ];


        // ✅ Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(products::class);
    }
}

