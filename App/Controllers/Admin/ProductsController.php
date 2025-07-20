<?php

namespace App\Controllers\Admin;

use App\Models\Product;
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
        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }
        $this->view('admin/products/show', [
            'product' => $product
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/products/create');
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
        $this->view('admin/products/edit', [
            'product' => $product
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
        $product->fill($_POST);
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
