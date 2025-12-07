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

        // Get the product - just basic info from products table
        $product = Product::find($id);

        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/gallery');
            return;
        }

        // Convert to array for consistent access
        if (is_object($product)) {
            $productData = [
                'id' => $product->id ?? null,
                'name' => $product->name ?? '',
                'description' => $product->description ?? '',
                'category_id' => $product->category_id ?? null,
                'image_url' => $product->image_url ?? '',
                'created_at' => $product->created_at ?? null
            ];
        } else {
            $productData = $product;
        }

        // Ensure required keys exist
        $productData['id'] = $productData['id'] ?? $id;
        $productData['name'] = $productData['name'] ?? 'Unknown Product';
        $productData['description'] = $productData['description'] ?? '';
        $productData['category_id'] = $productData['category_id'] ?? null;

        // Pass minimal data to view - view will load additional data as needed
        $this->view('product-detail', [
            'product' => $productData,
            'productId' => $productData['id']
        ]);
    }
}
