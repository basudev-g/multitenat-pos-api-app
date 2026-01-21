<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseTenantModel
{
    protected $fillable = ['name', 'phone'];
}
