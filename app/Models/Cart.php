<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $guarded = [];
    protected $table = "carts";


    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }


    public function addItem($productId, $quantity, $price, $attributes = [])
    {
        $productId = (int)$productId;

        // Check if item already exists in the cart
        $cartItem = CartItem::where('cart_id', $this->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'price' => $price,
                'quantity' => $quantity,
                'attributes' => $attributes, // ✅ only here
            ]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $this->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'attributes' => $attributes, // ✅ not separate keys
            ]);
        }

        return $cartItem;
    }


    public function product()
{
    return $this->belongsTo(products::class, 'product_id', 'id');
}

}
