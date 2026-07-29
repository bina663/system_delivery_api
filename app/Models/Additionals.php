<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Additionals extends Model
{
    protected $fillable = [
        'id',
        'name',
        'value',
        'status'
    ];
}
