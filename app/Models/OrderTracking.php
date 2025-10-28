<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    //

     protected $table = 'order_trackings';

    protected $guarded = [];


    // Relationships
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }

    // Helper to get readable status
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            0 => 'Canceled',
            1 => 'Order Placed',
            2 => 'Order Dispatched',
            3 => 'Order Completed',
            default => 'Unknown',
        };
    }
}
