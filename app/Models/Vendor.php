<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Authenticatable
{
    //
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $guarded = [];

    protected $table = 'vendors';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(BankDetails::class, 'vendor_id');
    }

    public function products()
{
    return $this->hasMany(products::class, 'vendor_id', 'id');
}
}
