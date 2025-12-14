<?php

namespace App\Controllers\App;

use Core\Controller;
use App\Models\Product;
use App\Models\Gallery;
use FontLib\Table\Type\head;

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

        $this->view('gallery', [
            'galleryItems' => $galleryItems
        ]);
    }

    public function show($id)
    {
        $this->view->layout('app');

        // Get the product
        $product = Product::find($id);

        // Redirect if product not found
        if (!$product) {
            header('Location: ' . url('gallery'));
            exit;
        }

        // Get product images
        $images = Product::getImages($id);

        // Convert to array and add leading slash to image URLs
        $processedImages = [];
        foreach ($images as $image) {
            $imageArray = is_array($image) ? $image : (array)$image;
            if (isset($imageArray['image_url'])) {
                $imageArray['image_url'] = '/' . ltrim($imageArray['image_url'], '/');
                $processedImages[] = $imageArray;
            }
        }
        $images = $processedImages;

        // Get variants information
        $variants = Product::getVariants($id);
        $hasVariants = Product::hasVariants($id);

        // Combine product images and variant images
        $allImages = $images;

        // Attach images to each variant and add to main image gallery
        if ($hasVariants && !empty($variants)) {
            foreach ($variants as &$variant) {
                $variantImages = Gallery::where('related_id', '=', $variant['id'])
                    ->where('image_type', '=', 'variant')
                    ->get();

                if (!empty($variantImages)) {
                    foreach ($variantImages as $vImg) {
                        $vImgArray = is_array($vImg) ? $vImg : (array)$vImg;
                        $vImgArray['image_url'] = '/' . ltrim($vImgArray['image_url'], '/');
                        $allImages[] = $vImgArray;
                    }
                    // Use the first processed image for the variant
                    $firstVarImg = is_array($variantImages[0]) ? $variantImages[0] : (array)$variantImages[0];
                    $variant['image'] = '/' . ltrim($firstVarImg['image_url'], '/');
                } else {
                    $variant['image'] = null;
                }
            }
            unset($variant);
        }

        // Calculate price range
        $priceRange = null;
        if ($hasVariants && !empty($variants)) {
            $prices = array_column($variants, 'price');
            $minPrice = min($prices);
            $maxPrice = max($prices);
            $priceRange = $minPrice == $maxPrice ?
                '$' . number_format($minPrice, 2) :
                '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
        } else {
            $priceRange = '$' . number_format($product->price ?? 0, 2);
        }

        // Get reviews and rating
        $reviews = Product::getReviews($id);
        $overallRating = Product::getOverallRating($id);
        $reviewCount = count($reviews);

        // Get more products from same category (highest rated)
        $relatedProducts = [];
        if ($product->category_id) {
            $categoryProducts = Product::getByCategory($product->category_id);

            // Filter out current product and get ratings
            foreach ($categoryProducts as $relatedProduct) {
                $relatedId = is_array($relatedProduct) ? $relatedProduct['id'] : $relatedProduct->id;
                if ($relatedId != $id) {
                    $relatedArray = is_array($relatedProduct) ? $relatedProduct : (array)$relatedProduct;
                    $relatedArray['overall_rating'] = Product::getOverallRating($relatedId);
                    $relatedArray['review_count'] = count(Product::getReviews($relatedId));

                    // Get first image
                    $relatedImages = Product::getImages($relatedId);
                    $relatedArray['image_url'] = !empty($relatedImages) ? '/' . ltrim($relatedImages[0]['image_url'], '/') : null;

                    // Calculate price display
                    $hasRelatedVariants = Product::hasVariants($relatedId);
                    if ($hasRelatedVariants) {
                        $lowestPrice = Product::getLowestPrice($relatedId);
                        $relatedArray['price_display'] = 'From $' . number_format($lowestPrice, 2);
                    } else {
                        $relatedArray['price_display'] = '$' . number_format($relatedArray['price'] ?? 0, 2);
                    }

                    $relatedProducts[] = $relatedArray;
                }
            }            // Sort by rating (highest first)
            usort($relatedProducts, function ($a, $b) {
                return $b['overall_rating'] <=> $a['overall_rating'];
            });

            // Limit to 4 products
            $relatedProducts = array_slice($relatedProducts, 0, 4);
        }

        // Pass all data to view
        $this->view('product-detail', [
            'product' => $product,
            'images' => $allImages,
            'variants' => $variants,
            'hasVariants' => $hasVariants,
            'priceRange' => $priceRange,
            'reviews' => $reviews,
            'overallRating' => $overallRating,
            'reviewCount' => $reviewCount,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
