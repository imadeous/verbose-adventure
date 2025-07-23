<?php

namespace App\Models;

use Core\Model;
use Core\Database\QueryBuilder;

class Category extends Model
{
    protected ?string $table = 'categories';
    protected $fillable = [
        'name',
        'created_at'
    ];
    public function getProductsWithCategory($id)
    {
        return QueryBuilder::table('products')
            ->where('products.category_id', '=', $id)
            ->get();
    }
}
