<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products as ModelsProducts;
class Categories extends Model
{
      protected $fillable = [
        'name',
        '_status'
    ];

    public function products()
    {
        return $this->hasMany(ModelsProducts::class, 'category_id');
    }
}
