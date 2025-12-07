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
                    'image_url' => $firstImage['image_url'] ?? 'https://dummyimage.com/600x360',
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
        
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/gallery');
            return;
        }

        // Convert to array for consistent access
        $productData = is_array($product) ? $product : (array)$product;
        
        // Get product details
        $productId = $productData['id'];
        $images = Product::getImages($productId);
        $reviews = Product::getReviews($productId);
        $overallRating = Product::getOverallRating($productId);
        $variants = Product::getVariants($productId);
        $hasVariants = Product::hasVariants($productId);
        $priceRange = $hasVariants ? Product::getPriceRange($productId) : null;
        $categoryName = $productData['category_id'] ? Product::getCategoryName($productData['category_id']) : 'General';

        // Process reviews for display
        $reviewsData = [];
        foreach ($reviews as $review) {
            $reviewsData[] = is_array($review) ? $review : (array)$review;
        }

        // Process images
        $imagesData = [];
        foreach ($images as $image) {
            $imagesData[] = is_array($image) ? $image : (array)$image;
        }

        // Process variants
        $variantsData = [];
        foreach ($variants as $variant) {
            $variantsData[] = is_array($variant) ? $variant : (array)$variant;
        }

        $this->view('product-detail', [
            'product' => $productData,
            'images' => $imagesData,
            'reviews' => $reviewsData,
            'overallRating' => $overallRating,
            'variants' => $variantsData,
            'hasVariants' => $hasVariants,
            'priceRange' => $priceRange,
            'categoryName' => $categoryName,
            'reviewCount' => count($reviewsData)
        ]);
    }
}
