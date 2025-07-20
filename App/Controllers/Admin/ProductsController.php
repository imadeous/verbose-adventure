<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Product;

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
        $product = Product::find($id);
        $this->view->layout('admin');
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
        $product = Product::find($id);
        $this->view->layout('admin');
        $this->view('admin/products/edit', [
            'product' => $product
        ]);
    }

    public function update($id)
    {
        $product = Product::find($id);
        $product->fill($_POST);
        $product->save();
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
