<?php

namespace App\Models;

use Core\Model;

class Quote extends Model
{
    protected ?string $table = 'quotes';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'instagram',
        'delivery_address',
        'billing_address',
        'product_type',
        'material',
        'quantity',
        'timeline',
        'description',
        'budget',
        'created_at'
    ];
}
