<?php

namespace App\Models;


class Order extends BaseTenantModel
{
    protected $fillable = [
        'customer_id',
        'status',
        'total_amount'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
