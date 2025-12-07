<?php

namespace App\Models;

use Core\Model;
use Core\Database\QueryBuilder;

class Variant extends Model
{
    protected ?string $table = 'variants';
    protected $fillable = [
        'product_id',
        'dimensions',
        'weight_grams',
        'material',
        'color',
        'finishing',
        'assembly_required',
        'price',
        'sku',
        'stock_quantity',
        'created_at'
    ];

    /**
     * Get the product this variant belongs to
     */
    public function getProduct()
    {
        if (!$this->product_id) {
            return null;
        }
        return Product::find($this->product_id);
    }

    /**
     * Get all variants for a specific product
     */
    public static function getByProduct($productId)
    {
        return QueryBuilder::table('variants')
            ->where('product_id', '=', $productId)
            ->get();
    }

    /**
     * Format weight in human-readable format
     */
    public function getFormattedWeight()
    {
        if (!$this->weight) {
            return null;
        }

        $grams = (float)$this->weight;

        if ($grams >= 1000) {
            return round($grams / 1000, 2) . ' kg';
        }

        return $grams . ' g';
    }

    /**
     * Check if assembly is required
     */
    public function requiresAssembly()
    {
        return (bool)$this->assembly_required;
    }

    /**
     * Get color as hex code
     */
    public function getColorHex()
    {
        if (!$this->color) {
            return null;
        }

        // Ensure color has # prefix
        return strpos($this->color, '#') === 0 ? $this->color : '#' . $this->color;
    }

    /**
     * Get the lowest priced variant for a product
     */
    public static function getLowestPrice($productId)
    {
        $result = QueryBuilder::table('variants')
            ->where('product_id', '=', $productId)
            ->orderBy('price', 'ASC')
            ->limit(1)
            ->get();

        return !empty($result) ? $result[0]->price : null;
    }

    /**
     * Get the highest priced variant for a product
     */
    public static function getHighestPrice($productId)
    {
        $result = QueryBuilder::table('variants')
            ->where('product_id', '=', $productId)
            ->orderBy('price', 'DESC')
            ->limit(1)
            ->get();

        return !empty($result) ? $result[0]->price : null;
    }

    /**
     * Get price range for a product
     */
    public static function getPriceRange($productId)
    {
        $lowest = self::getLowestPrice($productId);
        $highest = self::getHighestPrice($productId);

        if ($lowest === null) {
            return null;
        }

        if ($lowest == $highest) {
            return '$' . number_format($lowest, 2);
        }

        return '$' . number_format($lowest, 2) . ' - $' . number_format($highest, 2);
    }
}
