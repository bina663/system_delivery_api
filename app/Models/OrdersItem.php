<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
class OrdersItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'additionals',
        'status',
    ];
    protected $casts = [
        'additionals' => 'array', // decodifica o JSON automaticamente
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class); // se existir tabela de produtos
    }

}
