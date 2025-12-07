<?php

namespace App\Controllers\App;

use Core\Controller;
use App\Models\Product;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $this->view->layout('app');

        // Get all products with images
        $products = Product::all() ?? [];

        // Filter products that have gallery images
        $galleryItems = [];
        foreach ($products as $product) {
            $productId = is_array($product) ? $product['id'] : $product->id;
            $productName = is_array($product) ? $product['name'] : $product->name;
            $productDescription = is_array($product) ? $product['description'] : $product->description;
            $categoryId = is_array($product) ? ($product['category_id'] ?? null) : ($product->category_id ?? null);

            // Get product images from gallery
            $images = Product::getImages($productId);

            if (!empty($images)) {
                $firstImage = is_array($images[0]) ? $images[0] : (array)$images[0];

                $galleryItems[] = [
                    'id' => $productId,
                    'name' => $productName,
                    'description' => $productDescription,
                    'image_url' => '/' . ($firstImage['image_url'] ?? 'https://dummyimage.com/600x360'),
                    'category_id' => $categoryId,
                    'category_name' => $categoryId ? Product::getCategoryName($categoryId) : 'General',
                    'image_count' => count($images)
                ];
            }
        }

        // Get statistics
        $totalProducts = count($products);
        $totalGalleryItems = count($galleryItems);

        $this->view('gallery', [
            'galleryItems' => $galleryItems,
            'totalProducts' => $totalProducts,
            'totalGalleryItems' => $totalGalleryItems
        ]);
    }

    public function show($id)
    {
        $this->view->layout('app');

        // Get the product
        $product = Product::find($id);

        // Get product images
        $images = Product::getImages($id);

        // Add leading slash to image URLs
        foreach ($images as &$image) {
            if (isset($image['image_url'])) {
                $image['image_url'] = '/' . $image['image_url'];
            }
        }
        unset($image);

        // Get variants information
        $variants = Product::getVariants($id);
        $hasVariants = Product::hasVariants($id);

        // Attach images to each variant
        if ($hasVariants && !empty($variants)) {
            foreach ($variants as &$variant) {
                $variantImages = Gallery::where('related_id', '=', $variant['id'])
                    ->where('image_type', '=', 'variant')
                    ->get();
                $variant['image'] = !empty($variantImages) ? '/' . $variantImages[0]['image_url'] : null;
            }
            unset($variant); // Break reference
        }

        // Pass all data to view
        $this->view('product-detail', [
            'product' => $product,
            'images' => $images,
            'variants' => $variants,
            'hasVariants' => $hasVariants,
        ]);
    }
}
