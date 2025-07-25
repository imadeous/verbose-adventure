<?php

namespace App\Models;

use Core\Model;
use App\Models\Category;
use App\Models\Gallery;
use Core\Database\QueryBuilder;

class Product extends Model


{
    protected ?string $table = 'products';
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'image_url',
        'created_at'
    ];

    public static function getCategoryName($category_id)
    {
        if (!$category_id) return null;
        // Assuming Category has a products() relationship
        return Category::find($category_id)->name ?? 'Uncategorized';
    }
    // get all products by category
    public static function getByCategory($category_id)
    {
        return Product::select('products.*')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', '=', $category_id)
            ->get();
    }

    public static function getImages($id)
    {
        $galleryRows = QueryBuilder::table('gallery')
            ->where('image_type', '=', 'product')
            ->andWhere('related_id', '=', $id)
            ->get();
        return $galleryRows;
    }

    // get product reviews()
    public static function getReviews($id)
    {
        $reviewRows = QueryBuilder::table('reviews')
            ->where('reviews.product_id', '=', $id)
            ->get();
        return $reviewRows;
    }

    // return an object with overall product rating
    public static function getOverallRating($id)
    {
        $reviews = Product::getReviews($id);
        if (empty($reviews)) return 0;

        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review->rating;
        }
        return round($totalRating / count($reviews), 1);
    }
}
