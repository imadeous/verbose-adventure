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

    // get all products by category
    public static function getByCategory($category_id)
    {
        return Product::select('products.*')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $category_id)
            ->get();
    }

    // get product reviews()
    public function getReviews($id)
    {
        return \App\Models\Review::select('reviews.*')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->where('reviews.product_id', $id)
            ->get();
    }

    // return an object with overall product rating
    public function getOverallRating($id)
    {
        $reviews = $this->getReviews($id);
        if (empty($reviews)) return 0;

        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review->rating;
        }
        return round($totalRating / count($reviews), 1);
    }
}
