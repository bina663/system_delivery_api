<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $fillable = [
        'code',
        'name',
        'value',
        'usage_limit',
        'used_count',
        '_status',
        'expires_at',
    ];
}
