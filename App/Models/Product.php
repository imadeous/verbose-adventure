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

    public function getCategoryName($category_id)
    {
        if (!$category_id) return null;
        // Assuming Category has a products() relationship
        return Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $category_id)
            ->get();
    }
}
