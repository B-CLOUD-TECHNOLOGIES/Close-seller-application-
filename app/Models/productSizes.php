<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productSizes extends Model
{
    //
    protected $guarded = [];
    protected $table = "product_sizes";

    static function DeleteSizeRecord($product_id)
    {
        self::where('product_id', $product_id)->delete();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
