<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class colors extends Model
{
    //
        protected $guarded = [];

    protected $table = "colors";

    
    static public function getSingle($id){
        return self::find($id);
    }

}
