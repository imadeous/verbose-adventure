<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Core\AdminControllerBase;

class ProductsController extends AdminControllerBase
{
    public function index()
    {
        $products = Product::all();
        $this->view->layout('admin');
        $this->view('admin/products/index', [
            'products' => $products
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $product = Product::find($id);
        $reviews = $product ? $product->getReviews($id) : [];
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $this->view('admin/products/show', [
            'product' => $product,
            'reviews' => $reviews
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $categories = Category::all();
        $this->view('admin/products/create', [
            'categories' => $categories
        ]);
    }

    public function store()
    {
        $data = $_POST;
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
        $categories = Category::sort('*', 'name', 'asc');
        $this->view('admin/products/edit', [
            'product' => $product,
            'categories' => $categories
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
        $this->redirect('/admin/products');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            flash('success', 'Product deleted successfully.');
        } else {
            flash('error', 'Product not found.');
        }
        $this->redirect('/admin/products');
    }
}
