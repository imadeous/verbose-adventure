<?php

namespace App\Models;

use Core\Model;
use App\Models\Product;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'created_at'
    ];
    public function getProductsWithCategory()
    {
        return Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $this->id)
            ->get();
    }
}
