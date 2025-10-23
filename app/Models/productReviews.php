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
}
