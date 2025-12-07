<?php

namespace App\Models;

use Core\Model;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Variant;
use Core\Database\QueryBuilder;

class Product extends Model


{
    protected ?string $table = 'products';
    protected $fillable = [
        'name',
        'category_id',
        'description',
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
            $reviewData = is_array($review) ? $review : (array)$review;

            // Calculate average from all rating categories
            $ratings = [
                $reviewData['quality_rating'] ?? 0,
                $reviewData['pricing_rating'] ?? 0,
                $reviewData['communication_rating'] ?? 0,
                $reviewData['packaging_rating'] ?? 0,
                $reviewData['delivery_rating'] ?? 0
            ];

            $validRatings = array_filter($ratings);
            if (!empty($validRatings)) {
                $avgRating = array_sum($validRatings) / count($validRatings);
                $totalRating += $avgRating;
            }
        }
        return count($reviews) > 0 ? round($totalRating / count($reviews), 1) : 0;
    }

    /**
     * Get all variants for this product
     */
    public static function getVariants($id)
    {
        return Variant::getByProduct($id);
    }

    /**
     * Get the price range for this product based on variants
     */
    public static function getPriceRange($id)
    {
        return Variant::getPriceRange($id);
    }

    /**
     * Get the lowest price variant
     */
    public static function getLowestPrice($id)
    {
        return Variant::getLowestPrice($id);
    }

    /**
     * Get the highest price variant
     */
    public static function getHighestPrice($id)
    {
        return Variant::getHighestPrice($id);
    }

    /**
     * Check if product has variants
     */
    public static function hasVariants($id)
    {
        $variants = self::getVariants($id);
        return !empty($variants);
    }
}
