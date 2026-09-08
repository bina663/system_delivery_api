<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Additionals extends Model
{
    protected $table = 'additionals';

    protected $fillable = [
        'id',
        'name',
        'value',
        '_status'
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_additional',
            'additional_id',
            'product_id'
        );
    }
}
