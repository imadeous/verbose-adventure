<?php

namespace App\Models;

use Core\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';
    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_to',
        'usage_limit',
        'used_count',
        'min_order_value',
        'status',
        'created_at'
    ];
}
