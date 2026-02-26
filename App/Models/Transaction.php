<?php

namespace App\Models;

use Core\Model;

class Transaction extends Model
{
    protected ?string $table = 'transactions';
    protected string $primaryKey = 'id';
    protected $fillable = [
        'type', // 'income' or 'expense'
        'category_id', // for categorizing transactions (auto-filled for income with SKU)
        'product_id', // only for income transactions with product SKU
        'variant_id', // only for income transactions with variant SKU
        'amount',
        'description', // optional
        'quote_id', // optional
        'promo_code_id', // optional
        'platform', // e.g., 'whatsapp', 'instagram', 'website', 'phone'
        'customer_username', // optional customer identifier
        'date',
        'created_at'
    ];

    protected $appends = [
        'category_name',
        'product_name',
        'variant_info'
    ];

    public function getCategoryNameAttribute(): ?string
    {
        if (!$this->category_id) return null;
        $category = \App\Models\Category::find($this->category_id);
        return $category ? $category->name : null;
    }

    public function getProductNameAttribute(): ?string
    {
        if (!$this->product_id) return null;
        $product = \App\Models\Product::find($this->product_id);
        return $product ? $product->name : null;
    }

    public function getVariantInfoAttribute(): ?array
    {
        if (!$this->variant_id) return null;
        $variant = \App\Models\Variant::find($this->variant_id);
        if (!$variant) return null;

        return [
            'id' => $variant->id,
            'sku' => $variant->sku,
            'price' => $variant->price,
            'dimensions' => $variant->dimensions,
            'material' => $variant->material,
            'color' => $variant->color
        ];
    }

    /**
     * Get the category relationship
     */
    public function getCategory()
    {
        if (!$this->category_id) return null;
        return \App\Models\Category::find($this->category_id);
    }

    /**
     * Get the product relationship
     */
    public function getProduct()
    {
        if (!$this->product_id) return null;
        return \App\Models\Product::find($this->product_id);
    }

    /**
     * Get the variant relationship
     */
    public function getVariant()
    {
        if (!$this->variant_id) return null;
        return \App\Models\Variant::find($this->variant_id);
    }

    /**
     * Get the promo code relationship
     */
    public function getPromoCode()
    {
        if (!$this->promo_code_id) return null;
        return \App\Models\PromoCode::find($this->promo_code_id);
    }
}
