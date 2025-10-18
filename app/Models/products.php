<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //

    protected $guarded = [];

    protected $table = "products";

    protected $casts = [
        'tags' => 'array',
    ];


    public function getCategory()
    {
        return $this->belongsTo(categories::class, 'category_id', 'id');
    }


    public function getColor()
    {
        return $this->hasMany(productColors::class, 'product_id');
    }


    public function getSize()
    {
        return $this->hasMany(productSizes::class, 'product_id');
    }

    public function getImage()
    {
        return $this->hasMany(productImages::class, 'product_id')->orderBy('order_by', 'ASC');
    }

    public function getFirstImage()
    {
        $firstImage = productImages::where('product_id', $this->id)
            ->orderBy('order_by', 'ASC')
            ->take(2)
            ->get();

        return $firstImage->first();
    }
}
