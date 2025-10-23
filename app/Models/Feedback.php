<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'topic',
        'type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(Vendor::class);
    }
}
