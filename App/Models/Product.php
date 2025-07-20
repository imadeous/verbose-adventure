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
        'price',
        'image_url',
        'created_at'
    ];

    public function getCategoryName()
    {
        if (!$this->category_id) return null;
        $category = \App\Models\Category::find($this->category_id);
        return $category ? $category->name : null;
    }
}
