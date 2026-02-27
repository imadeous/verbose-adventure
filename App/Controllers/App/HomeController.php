<?php

namespace App\Controllers\App;

use Core\Controller;
use App\Models\Product;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index()
    {
        // Set the layout (optional)
        $this->view->layout('app'); // uses App/Views/layouts/app.php

        // Get top rated products (with ratings)
        $allProducts = Product::all() ?? [];
        $topRatedProducts = [];

        foreach ($allProducts as $product) {
            $productId = is_array($product) ? $product['id'] : $product->id;
            $rating = Product::getOverallRating($productId);

            if ($rating > 0) {
                // Properly extract all fields
                $productArray = [
                    'id' => $productId,
                    'name' => is_array($product) ? $product['name'] : $product->name,
                    'description' => is_array($product) ? ($product['description'] ?? '') : ($product->description ?? ''),
                    'price' => is_array($product) ? ($product['price'] ?? 0) : ($product->price ?? 0),
                    'category_id' => is_array($product) ? ($product['category_id'] ?? null) : ($product->category_id ?? null),
                    'rating' => $rating,
                    'review_count' => count(Product::getReviews($productId))
                ];

                // Get first image
                $images = Product::getImages($productId);
                $productArray['image_url'] = !empty($images) ? '/' . ltrim($images[0]['image_url'], '/') : null;

                // Get price display
                $hasVariants = Product::hasVariants($productId);
                if ($hasVariants) {
                    $lowestPrice = Product::getLowestPrice($productId);
                    $productArray['price_display'] = 'From $' . number_format($lowestPrice, 2);
                } else {
                    $productArray['price_display'] = '$' . number_format($productArray['price'], 2);
                }

                $topRatedProducts[] = $productArray;
            }
        }

        // Sort by rating and limit to 4
        usort($topRatedProducts, function ($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });
        $topRatedProducts = array_slice($topRatedProducts, 0, 4);

        // Get best selling products (based on transaction count)
        $bestSellingProducts = [];
        foreach ($allProducts as $product) {
            $productId = is_array($product) ? $product['id'] : $product->id;

            // Count transactions for this product
            $transactionCount = Product::getTransactionCount($productId);

            if ($transactionCount > 0) {
                // Properly extract all fields
                $productArray = [
                    'id' => $productId,
                    'name' => is_array($product) ? $product['name'] : $product->name,
                    'description' => is_array($product) ? ($product['description'] ?? '') : ($product->description ?? ''),
                    'price' => is_array($product) ? ($product['price'] ?? 0) : ($product->price ?? 0),
                    'category_id' => is_array($product) ? ($product['category_id'] ?? null) : ($product->category_id ?? null),
                    'transaction_count' => $transactionCount,
                    'rating' => Product::getOverallRating($productId),
                    'review_count' => count(Product::getReviews($productId))
                ];

                // Get first image
                $images = Product::getImages($productId);
                $productArray['image_url'] = !empty($images) ? '/' . ltrim($images[0]['image_url'], '/') : null;

                // Get price display
                $hasVariants = Product::hasVariants($productId);
                if ($hasVariants) {
                    $lowestPrice = Product::getLowestPrice($productId);
                    $productArray['price_display'] = 'From MVR ' . number_format($lowestPrice, 2);
                } else {
                    $productArray['price_display'] = 'MVR ' . number_format($productArray['price'], 2);
                }

                $bestSellingProducts[] = $productArray;
            }
        }

        // Sort by transaction count and limit to 4
        usort($bestSellingProducts, function ($a, $b) {
            return $b['transaction_count'] <=> $a['transaction_count'];
        });
        $bestSellingProducts = array_slice($bestSellingProducts, 0, 4);

        // Unique customers count (where customer_username is not null)
        $uniqueCustomers = Transaction::query()
            ->selectRaw('COUNT(DISTINCT customer_username) as count')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->count('*')->count;

        // Render the view and pass data
        $this->view('index', [
            'topRatedProducts' => $topRatedProducts,
            'bestSellingProducts' => $bestSellingProducts,
            'uniqueCustomers' => $uniqueCustomers

        ]);
    }

    /**
     * Show a generic page by title
     *
     * @param string $pageTitle
     */
    public function page($pageTitle)
    {
        $this->view->layout('app');
        // Convert page title to lowercase and replace spaces with underscores for view file name
        $viewName = strtolower(str_replace(' ', '_', $pageTitle));
        $this->view($viewName, [
            'title' => $pageTitle,
        ]);
    }
}
