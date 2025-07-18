<?php

namespace App\Models;

use Core\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'image_url',
        'created_at'
    ];
}
