<?php

namespace App\Models;

use Core\Model;

class Transaction extends Model
{
    protected ?string $table = 'transactions';
    protected string $primaryKey = 'id';
    protected $fillable = [
        'type',
        'category_id',
        'amount',
        'description',
        'quote_id',
        'promo_code_id',
        'date',
        'created_at'
    ];

    protected $appends = [
        'category_name'
    ];

    public function getCategoryNameAttribute(): ?string
    {
        $category = \App\Models\Category::find($this->category_id);
        return $category ? $category->name : null;
    }
}
