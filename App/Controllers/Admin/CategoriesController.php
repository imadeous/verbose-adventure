<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use Core\AdminControllerBase;

class CategoriesController extends AdminControllerBase
{
    public function index()
    {
        $categories = Category::all();
        $this->view->layout('admin');
        $this->view('admin/categories/index', [
            'categories' => $categories
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
            'products' => $products
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/categories/create');
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
            'category' => $category
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
        $category->save();
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
