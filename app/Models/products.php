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
}
