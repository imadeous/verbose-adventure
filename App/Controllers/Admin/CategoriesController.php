<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Core\AdminControllerBase;
use Core\Database\ReportBuilder;

class CategoriesController extends AdminControllerBase
{
    public function index()
    {
        $categories = Category::query()->orderBy('name', 'asc')->get();

        // Enrich each category with analytics
        $enrichedCategories = [];
        foreach ($categories as $category) {
            // Get transaction stats for this category
            $stats = ReportBuilder::build('transactions', 'date')
                ->where('type', '=', 'income')
                ->where('category_id', '=', $category['id'])
                ->withSum('amount', 'Revenue')
                ->withCount('*', 'Orders')
                ->generate()['data'][0] ?? [];

            // Get product count for this category
            $productCount = count(Product::query()->where('category_id', '=', $category['id'])->get());

            $category['total_orders'] = $stats['Orders'] ?? 0;
            $category['total_revenue'] = $stats['Revenue'] ?? 0;
            $category['total_products'] = $productCount;

            $enrichedCategories[] = $category;
        }

        $this->view->layout('admin');
        $this->view('admin/categories/index', [
            'categories' => $enrichedCategories,
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
