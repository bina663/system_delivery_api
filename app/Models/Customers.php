<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = [
        'name',
        'telephone',
        'email',
        'zip_code',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
        'point_reference',
        'status'
    ];
}
