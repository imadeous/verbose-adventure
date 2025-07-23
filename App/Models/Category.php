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
            ->select('products.*')
            ->where('categories.id', '=', $id)
            ->get();
}
