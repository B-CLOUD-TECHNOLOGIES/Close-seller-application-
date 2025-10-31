<?php

namespace App\Models;

use App\Models\colors as ModelsColors;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Html\Colors;

class productColors extends Model
{
    //

    protected $guarded = [];
    protected $table = "product_colors";

    static function DeleteRecord($product_id)
    {
        self::where('product_id', $product_id)->delete();
    }

    public function getProductColor()
    {
        return $this->belongsTo(color::class, 'color_id', 'id');
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
