<?php

namespace App\Models;

use Core\Model;

/**
 * Product model
 *
 * Represents a product in the application.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property string $sku
 * @property string $unit
 * @property int $category_id
 */
class Product extends Model
{
    protected static $table = 'products';
    protected static $fillable = ['title', 'description', 'price', 'sku', 'unit', 'category_id'];

    /**
     * Validation rules for the Product model.
     * @return array
     */
    public static function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'sku' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'unit' => [self::RULE_REQUIRED],
            'category_id' => [self::RULE_REQUIRED, [self::RULE_NUMBER, 'min' => 1]],
        ];
    }
}
