<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use Core\AdminControllerBase;

class CategoriesController extends AdminControllerBase
{
    public function index()
    {
        $categories = Category::query()->orderBy('name', 'asc')->get();
        $this->view->layout('admin');
        $this->view('admin/categories/index', [
            'categories' => $categories,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Categories']
            ]
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $category = Category::find($id);
        if (!$category) {
            flash('error', 'Category not found.');
            $this->redirect('/admin/categories');
            return;
        }
        // Assuming Category has a products() relationship
        $products = $category->getProductsWithCategory($id);
        $this->view('admin/categories/show', [
            'category' => $category,
            'products' => $products,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Categories', 'url' => url('admin/categories')],
                ['label' => $category->name]
            ]
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/categories/create', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Categories', 'url' => url('admin/categories')],
                ['label' => 'Create']
            ]
        ]);
    }

    public function store()
    {
        $data = $_POST;
        $category = new Category($data);
        $category->save();
        $this->redirect('/admin/categories');
    }

    public function edit($id)
    {
        $this->view->layout('admin');
        $category = Category::find($id);
        if (!$category) {
            flash('error', 'Category not found.');
            $this->redirect('/admin/categories');
            return;
        }
        $this->view('admin/categories/edit', [
            'category' => $category,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Categories', 'url' => url('admin/categories')],
                ['label' => 'Edit']
            ]
        ]);
    }

    public function update($id)
    {
        $category = Category::find($id);
        if (!$category) {
            flash('error', 'Category not found.');
            $this->redirect('/admin/categories');
            return;
        }
        $category->fill($_POST);
        // Ensure the primary key is set for update
        $category->id = $id;
        $category->update();
        flash('success', 'Category updated successfully.');
        $this->redirect('/admin/categories');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            flash('success', 'Category deleted successfully.');
        } else {
            flash('error', 'Category not found.');
        }
        $this->redirect('/admin/categories');
    }
}
