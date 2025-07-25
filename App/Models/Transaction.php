<?php

namespace App\Models;

use Core\Model;

class Transaction extends Model
{
    protected ?string $table = 'transactions';
    protected string $primaryKey = 'id';
    protected $fillable = [
        'type',
        'category',
        'amount',
        'description',
        'quote_id',
        'promo_code_id',
        'date',
        'created_at'
    ];
}
