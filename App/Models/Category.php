<?php

namespace App\Models;

use Core\Model;
use App\Models\Product;

class Category extends Model
{
    protected ?string $table = 'categories';
    protected $fillable = [
        'name',
        'created_at'
    ];
    public function getProductsWithCategory($id)
    {
        return Product::select('products.*')
            ->where('products.category_id', '=', $id)
            ->get();
    }
}
