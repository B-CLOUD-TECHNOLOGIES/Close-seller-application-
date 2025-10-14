<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productImages extends Model
{
    //
    protected $guarded = [];
    protected $table = "product_images";


        function getAllImages(){
        if(!empty($this->image_name) && file_exists($this->image_name)){
            return url($this->image_name);
        }else{
            return '';
        }
    }
    function getAllZoomImages(){
        if(!empty($this->image_zoom) && file_exists($this->image_zoom)){
            return url($this->image_zoom);
        }else{
            return '';
        }
    }
}
