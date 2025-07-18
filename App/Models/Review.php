<?php

namespace App\Models;

use Core\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'quote_id',
        'customer_name',
        'customer_email',
        'quality_rating',
        'pricing_rating',
        'communication_rating',
        'packaging_rating',
        'delivery_rating',
        'recommendation_score',
        'comments',
        'created_at'
    ];
}
