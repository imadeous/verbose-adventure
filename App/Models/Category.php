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
    public function getProducts()
    {
        return Product::where('category_id', $this->id);
    }
}
