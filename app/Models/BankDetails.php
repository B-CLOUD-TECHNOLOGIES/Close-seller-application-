<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    protected $fillable = [
        'vendor_id', 'bankCode', 'bankName', 'acctName', 'acctNo', 'recipient_code',
    ];
}
