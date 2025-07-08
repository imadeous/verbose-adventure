<?php

namespace App\Controllers\Admin;

use App\Helpers\Breadcrumb;
use App\Models\Product;
use Core\Controller;
use Core\Request;
use Core\Csrf;

class ProductController extends Controller
{
    public function index()
    {
        Breadcrumb::add([
            ['label' => 'Products', 'url' => 'admin/products'],
            ['label' => 'List']
        ]);
        $products = Product::all();
        return $this->view('admin/products/index', ['products' => $products], 'admin');
    }

    public function create()
    {
        Breadcrumb::add([
            ['label' => 'Products', 'url' => 'admin/products'],
            ['label' => 'New Product']
        ]);
        return $this->view('admin/products/create', [], 'admin');
    }

    public function store()
    {
        if (!Csrf::verify(Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            redirect(url('admin/products/create'));
            return;
        }

        $product = new Product();
        $product->title = Request::post('title');
        $product->description = Request::post('description');
        $product->price = Request::post('price');
        $product->sku = Request::post('sku');
        $product->unit = Request::post('unit');
        // Assuming category_id will be added to the form later
        // $product->category_id = Request::post('category_id');

        if ($product->save()) {
            session()->flash('success', 'Product created successfully!');
            redirect('admin/products');
        } else {
            session()->flash('error', 'Failed to create product.');
            // You might want to pass the submitted data back to the view
            redirect('admin/products/create');
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        Breadcrumb::add([
            ['label' => 'Products', 'url' => 'admin/products'],
            ['label' => $product->title, 'url' => 'admin/products/show/' . $id]
        ]);
        return $this->view('admin/products/show', ['product' => $product], 'admin');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return $this->view('admin/products/edit', ['product' => $product], 'admin');
    }

    public function update($id)
    {
        if (!Csrf::verify(Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            redirect(url('admin/products/edit/' . $id));
            return;
        }

        $product = Product::find($id);
        if ($product) {
            $product->title = Request::post('title');
            $product->description = Request::post('description');
            $product->price = Request::post('price');
            $product->sku = Request::post('sku');
            $product->unit = Request::post('unit');
            // $product->category_id = Request::post('category_id');

            if ($product->save()) {
                session()->flash('success', 'Product updated successfully!');
                redirect('admin/products/show/' . $id);
            } else {
                session()->flash('error', 'Failed to update product.');
                redirect('admin/products/edit/' . $id);
            }
        } else {
            session()->flash('error', 'Product not found.');
            redirect('admin/products');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            session()->flash('success', 'Product deleted successfully!');
        } else {
            session()->flash('error', 'Product not found.');
        }
        redirect('admin/products');
    }
}
