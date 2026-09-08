<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'value',
        'category_id',
        'status',
        'description',
        'image',
        '_status'
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function additionals()
    {
        return $this->belongsToMany(
            Additionals::class,
            'product_additional',
            'product_id',
            'additional_id'
        );
    }
}
