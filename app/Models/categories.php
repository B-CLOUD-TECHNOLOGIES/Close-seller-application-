<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    //

    protected $guarded = [];

    protected $table = "categories";


    // public function getProductCount(){
    //     return $this->hasMany(products::class, "category_id","id")->count();
    // } 

    public function getProductCount() {
    return $this->hasMany(Products::class, 'category_id', 'id');
}

}
