<?php

namespace App\Models;

use Core\Model;

/**
 * Category model
 *
 * Represents a product category in the application.
 *
 * @property int $id
 * @property string $title
 */
class Category extends Model
{
    protected static $table = 'categories';
    protected static $fillable = ['title'];

    /**
     * Validation rules for the Category model.
     * @return array
     */
    public static function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
        ];
    }
}
