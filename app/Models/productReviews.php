<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productReviews extends Model
{
    //

    protected $guarded = [];
    protected $table = "product_reviews";

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    static public function getReviewProduct($product_id)
    {
        return self::select('product_reviews.*', 'users.username', 'users.image')
            ->join('users', 'users.id', 'product_reviews.user_id')
            ->where('product_id', $product_id)
            ->orderBy('product_reviews.id', 'DESC')
            ->get();
    }


    static function getRatingAVG($product_id)
    {
        return self::select('product_reviews.rating')
            ->join('users', 'users.id', 'product_reviews.user_id')
            ->where('product_id', $product_id)
            ->avg('product_reviews.rating');
    }


    // ProductReview.php (Model)
    static function getRatingAVGLimit($product_id)
    {
        return self::where('product_id', $product_id)
            ->avg('rating');
    }


static public function getProductReview($product_id)
{
    return self::with('user') // eager-load user info
        ->where('product_id', $product_id)
        ->orderBy('id', 'DESC')
        ->get(); // use get() instead of paginate() for all reviews
}

}
