<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseTenantModel
{
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock',
        'low_stock_threshold'
    ];
}
