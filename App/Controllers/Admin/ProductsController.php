<?php

namespace App\Controllers\Admin;

use Core\Database\QueryBuilder;
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
        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products']
        ];
        $this->view('admin/products/index', [
            'products' => $products,
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
        $productTransactions = ReportBuilder::build('transactions', 'date')
            ->where('type', '=', 'product')
            ->with('description')
            ->where('description', '=', addslashes($product->name))
            ->withSum('amount', 'Total Revenue')
            ->withCount('*', 'Total Orders')
            ->generate()['data'][0] ?? [];
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => $product->name, 'url' => '/admin/products/' . $id]
        ];
        $this->view('admin/products/show', [
            'product' => $product,
            'productTransactions' => $productTransactions,
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
        $product = new Product($data);
        $product->save();
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
