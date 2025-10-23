<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //

    protected $guarded = [];

    protected $table = "orders";


    protected $casts = [
        'payment_data' => 'array',
    ];
}
