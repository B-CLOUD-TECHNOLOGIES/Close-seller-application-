<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class productWishlist extends Model
{
    //
    protected $guarded = [];

    protected $table = "product_wishlists";


    public static function getSingle($id)
    {
        return self::find($id);
    }

    public static function deleteRecord($product_id, $user_id)
    {
        return self::where('product_id', $product_id)->where('user_id', $user_id)->delete();;
    }

    public static function checkAlready($product_id, $user_id)
    {
        return self::where('product_id', $product_id)->where('user_id', $user_id)->count();;
    }


    public static function isInWishlist($productId, $userId)
    {
        return self::where('product_id', $productId)
            ->where('user_id', $userId)
            ->exists();
    }


    public function product()
    {
        return $this->belongsTo(products::class, 'product_id', 'id');
    }

    // Relationship: each wishlist item belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getUserWishlist()
    {
        return self::where('user_id', Auth::user()->id)
            ->get();
    }



    public static function getUserProductWishlist()
{
    return self::withAvg('reviews', 'rating')
        ->where('user_id', Auth::id())
        ->with('product') // eager-load the related products
        ->get()
        ->pluck('product'); // return only the product collection
}

}
