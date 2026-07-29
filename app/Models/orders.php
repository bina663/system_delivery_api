<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_phone',
        'total_value',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
