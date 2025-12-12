<?php

namespace App\Controllers\Admin;

use Core\Database\ChartBuilder;
use Core\AdminControllerBase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Review;
use Core\Database\ReportBuilder;

class ProductsController extends AdminControllerBase
{

    public function index()
    {
        $products = Product::all();

        // Enrich each product with analytics data
        $enrichedProducts = [];
        foreach ($products as $product) {
            // Get transaction stats
            $stats = ReportBuilder::build('transactions', 'date')
                ->where('type', '=', 'income')
                ->where('product_id', '=', $product->id)
                ->withSum('amount', 'Revenue')
                ->withCount('*', 'Orders')
                ->generate()['data'][0] ?? [];

            // Add analytics properties to product object
            $product->total_orders = $stats['Orders'] ?? 0;
            $product->total_revenue = $stats['Revenue'] ?? 0;

            // Get variants and stock
            $variants = Product::getVariants($product->id);
            $product->variant_count = count($variants);
            $product->total_stock = array_sum(array_map(function ($v) {
                return is_array($v) ? ($v['stock_quantity'] ?? 0) : ($v->stock_quantity ?? 0);
            }, $variants));

            // Calculate stock value
            $product->stock_value = Product::getStockValue($product->id);
            var_dump($product->stock_value);
            exit;
            $enrichedProducts[] = $product;
        }

        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products']
        ];
        $this->view('admin/products/index', [
            'products' => $enrichedProducts,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $product = Product::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $reviews = $product ? $product->getReviews($id) : [];
        $gallery = Product::getImages($id);

        // Use product_id instead of searching description
        $productTransactions = ReportBuilder::build('transactions', 'date')
            ->where('type', '=', 'income')
            ->where('product_id', '=', $id)
            ->with('description')
            ->withSum('amount', 'Total Revenue')
            ->withCount('*', 'Total Orders')
            ->generate()['data'][0] ?? [];

        // Get last 50 sales for chart using product_id
        $salesData =  ChartBuilder::build('transactions', 'date')
            ->daily()
            ->where('type', '=', 'income')
            ->andWhere('product_id', '=', $id)
            ->withSum('amount', 'Revenue')
            ->withCount('*', 'Orders')
            ->limit(10)
            ->legend(['display' => false])
            ->line()->toArray();

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => $product->name, 'url' => '/admin/products/' . $id]
        ];
        $this->view('admin/products/show', [
            'product' => $product,
            'productTransactions' => $productTransactions,
            'salesData' => $salesData,
            'reviews' => $reviews,
            'gallery' => $gallery,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $categories = Category::all();
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => 'Add Product', 'url' => '/admin/products/create']
        ];
        $this->view('admin/products/create', [
            'categories' => $categories,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function store()
    {
        $data = $_POST;
        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/create');
            return;
        }
        unset($data['_csrf'], $data['_method']);

        // Create the product first
        $product = new Product($data);
        $product->save();

        // Handle image uploads if any
        if (!empty($_FILES['images']['name'][0])) {
            $uploadedCount = 0;
            $maxImages = 8;

            foreach ($_FILES['images']['name'] as $index => $filename) {
                if ($uploadedCount >= $maxImages) {
                    break;
                }

                // Skip if no file was uploaded at this index
                if (empty($filename)) {
                    continue;
                }

                // Prepare file array in format expected by File::upload
                $file = [
                    'name' => $_FILES['images']['name'][$index],
                    'type' => $_FILES['images']['type'][$index],
                    'tmp_name' => $_FILES['images']['tmp_name'][$index],
                    'error' => $_FILES['images']['error'][$index],
                    'size' => $_FILES['images']['size'][$index]
                ];

                // Upload the file
                $result = \App\Helpers\File::upload($file, 'products', [
                    'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
                    'max_size' => 5 * 1024 * 1024 // 5MB
                ]);

                if ($result['success']) {
                    // Save to gallery table
                    $gallery = new Gallery([
                        'product_id' => $product->id,
                        'image_path' => $result['path']
                    ]);
                    $gallery->save();
                    $uploadedCount++;
                } else {
                    // Log error but continue with other images
                    error_log("Failed to upload image: " . $result['error']);
                }
            }

            if ($uploadedCount > 0) {
                flash('success', "Product created successfully with {$uploadedCount} image(s).");
            } else {
                flash('success', 'Product created successfully.');
            }
        } else {
            flash('success', 'Product created successfully.');
        }

        $this->redirect('/admin/products');
    }

    public function edit($id)
    {
        $this->view->layout('admin');
        $product = Product::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $categories = Category::query()->orderBy('name', 'asc')->get();
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => 'Edit: ' . $product->name, 'url' => '/admin/products/' . $id . '/edit']
        ];
        $this->view('admin/products/edit', [
            'product' => $product,
            'categories' => $categories,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function update($id)
    {
        $product = Product::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $data = $_POST;
        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/' . $id . '/edit');
            return;
        }
        // Remove _csrf and _method fields if present
        unset($data['_csrf'], $data['_method']);
        $product->fill($data);
        $product->save();
        flash('success', 'Product updated successfully.');
        $this->redirect('/admin/products/' . $id);
    }

    public function addImage($id)
    {
        $this->view->layout('admin');
        $product = Product::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => $product->name, 'url' => '/admin/products/' . $id],
            ['label' => 'Add Image', 'url' => '/admin/products/' . $id . '/addImage']
        ];
        $this->view('admin/products/addImage', [
            'product' => $product,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function storeImage($id)
    {
        $product = Product::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $data = $_POST;
        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/' . $id . '/addImage');
            return;
        }
        // Handle file upload and insert into gallery using Gallery model and File helper
        if (!empty($_FILES['image']['name'])) {
            $upload = \App\Helpers\File::upload(
                $_FILES['image'],
                'product',
                [
                    'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    'max_size' => 5 * 1024 * 1024 // 5MB
                ]
            );
            // Extract just the filename for DB
            $filename = $upload['success'] && !empty($upload['path']) ? basename($upload['path']) : null;
            if ($upload['success'] && $filename) {
                try {
                    $gallery = new \App\Models\Gallery([
                        'title' => $product->name,
                        'caption' => null,
                        'image_type' => 'product',
                        'related_id' => $product->id,
                        'image_url' => $filename,
                    ]);
                    $gallery->save();
                    flash('success', 'Image uploaded and added to gallery.');
                } catch (\Throwable $e) {
                    flash('error', 'Gallery save error: ' . $e->getMessage());
                }
            } else {
                flash('error', 'File upload error: ' . ($upload['error'] ?? 'No filename returned.'));
            }
        } else {
            flash('error', 'No image selected. Debug: ' . print_r($_FILES, true));
        }
        $this->redirect('/admin/products/' . $id);
    }

    public function variantsJson($id)
    {
        $product = Product::find($id);
        if (!$product) {
            header('Content-Type: application/json');
            echo json_encode(['variants' => []]);
            return;
        }

        $variants = \App\Models\Variant::query()
            ->where('product_id', '=', $id)
            ->orderBy('sku', 'ASC')
            ->get();

        header('Content-Type: application/json');
        echo json_encode(['variants' => $variants]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            // Delete associated images from Gallery and filesystem
            $galleryImages = \App\Models\Gallery::query()
                ->where('image_type', '=', 'product')
                ->where('related_id', '=', $id)
                ->get();
            foreach ($galleryImages as $img) {
                $imgPath = 'public/storage/products/' . $img['image_url'];
                \App\Helpers\File::delete($imgPath);
                // Optionally delete gallery record
                $gallery = new \App\Models\Gallery($img);
                $gallery->delete();
            }
            $product->delete();
            flash('success', 'Product deleted successfully.');
        } else {
            flash('error', 'Product not found.');
        }
        $this->redirect('/admin/products');
    }
}
