<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    //
    protected $table = 'notifications';
    protected $guarded = [];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function insertRecord($user_id, $user_type, $title, $url, $message, $is_admin = false)
    {
        $save = new notification();
        $save->user_id   = $user_id;
        $save->user_type = $user_type; // 'user', 'vendor', or 'admin'
        $save->title     = $title;
        $save->url       = $url;
        $save->message   = $message;
        $save->is_admin  = $is_admin;
        $save->is_read   = false; // default unread
        $save->save();
    }


    static public function getUnreadNotification()
    {
        return self::where('is_read', 0)
            ->where('is_Admin', 0)
            ->orderBy('id', 'desc')
            ->get();
    }


    static public function getRecord()
    {
        return self::where('is_Admin', 0)
            ->orderBy('id', 'desc')
            ->paginate(30);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


    // ======================================= USAGE ======================================= // 
    // For a user
    // notification::insertRecord(
    //     $user->id,
    //     'user',
    //     'Order Shipped',
    //     '/orders/1234',
    //     'Your order #1234 has been shipped successfully.',
    //     false
    // );

    // // For a vendor
    // notification::insertRecord(
    //     $vendor->id,
    //     'vendor',
    //     'New Order Received',
    //     '/vendor/orders/1234',
    //     'You have a new order from a customer.',
    //     false
    // );

    // // For admin
    // notification::insertRecord(
    //     null,
    //     'admin',
    //     'System Alert',
    //     '/admin/dashboard',
    //     'A new vendor just registered on the platform.',
    //     true
    // );

}
