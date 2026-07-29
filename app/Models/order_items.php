<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'value',
        'notes'
    ];

    public function order()
    {
        return $this->belongsTo(orders::class);
    }
}
