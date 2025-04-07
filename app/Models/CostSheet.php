<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostSheet extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'margin',
        'materials',
        'labor',
        'indirect',
        'total_cost',
        'unit_price',
    ];

    protected $casts = [
        'materials'   => 'array',
        'labor'       => 'array',
        'indirect'    => 'array',
        'total_cost'  => 'float',
        'unit_price'  => 'float',
    ];
}

