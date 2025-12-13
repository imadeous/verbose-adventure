<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Product;
use App\Models\Variant;

class VariantsController extends AdminControllerBase
{
    public function create($productId)
    {
        $this->view->layout('admin');
        $product = Product::find($productId);

        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => $product->name, 'url' => '/admin/products/' . $productId],
            ['label' => 'Add Variant', 'url' => '/admin/products/' . $productId . '/variants/create']
        ];

        $this->view('admin/variants/create', [
            'product' => $product,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function store($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            flash('error', 'Product not found.');
            $this->redirect('/admin/products');
            return;
        }

        $data = $_POST;

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/' . $productId);
            return;
        }

        unset($data['_csrf'], $data['_method']);

        // Add product_id to the data
        $data['product_id'] = $productId;

        // Handle assembly_required checkbox
        $data['assembly_required'] = isset($data['assembly_required']) ? 1 : 0;

        // Ensure color has # prefix if provided
        if (!empty($data['color']) && strpos($data['color'], '#') !== 0) {
            $data['color'] = '#' . $data['color'];
        }

        $variant = new Variant($data);
        $variant->save();

        flash('success', 'Variant added successfully.');
        $this->redirect('/admin/products/' . $productId);
    }

    public function edit($productId, $variantId)
    {
        $this->view->layout('admin');
        $product = Product::find($productId);
        $variant = Variant::find($variantId);

        if (!$product || !$variant) {
            flash('error', 'Product or variant not found.');
            $this->redirect('/admin/products');
            return;
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => '/admin'],
            ['label' => 'Products', 'url' => '/admin/products'],
            ['label' => $product->name, 'url' => '/admin/products/' . $productId],
            ['label' => 'Edit Variant', 'url' => '/admin/products/' . $productId . '/variants/' . $variantId . '/edit']
        ];

        $this->view('admin/variants/edit', [
            'product' => $product,
            'variant' => $variant,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function update($productId, $variantId)
    {
        $product = Product::find($productId);
        $variant = Variant::find($variantId);

        if (!$product || !$variant) {
            flash('error', 'Product or variant not found.');
            $this->redirect('/admin/products');
            return;
        }

        $data = $_POST;

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/' . $productId . '/variants/' . $variantId . '/edit');
            return;
        }

        unset($data['_csrf'], $data['_method']);

        // Handle assembly_required checkbox
        $data['assembly_required'] = isset($data['assembly_required']) ? 1 : 0;

        // Ensure color has # prefix if provided
        if (!empty($data['color']) && strpos($data['color'], '#') !== 0) {
            $data['color'] = '#' . $data['color'];
        }

        $variant->update($data);

        flash('success', 'Variant updated successfully.');
        $this->redirect('/admin/products/' . $productId);
    }

    public function destroy($productId, $variantId)
    {
        $variant = Variant::find($variantId);

        if ($variant) {
            $variant->delete();
            flash('success', 'Variant deleted successfully.');
        } else {
            flash('error', 'Variant not found.');
        }

        $this->redirect('/admin/products/' . $productId);
    }

    public function addStock($variantId)
    {
        $variant = Variant::find($variantId);

        if (!$variant) {
            flash('error', 'Variant not found.');
            $productId = $_POST['product_id'] ?? null;
            if ($productId) {
                $this->redirect('/admin/products/' . $productId);
            } else {
                $this->redirect('/admin/products');
            }
            return;
        }

        $data = $_POST;

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/products/' . $variant->product_id);
            return;
        }

        $quantity = isset($data['stock_quantity']) ? (int)$data['stock_quantity'] : 0;

        if ($quantity <= 0) {
            flash('error', 'Stock quantity must be greater than 0.');
            $this->redirect('/admin/products/' . $variant->product_id);
            return;
        }

        // Add to current stock
        $newStock = $variant->stock_quantity + $quantity;
        $variant->stock_quantity = $newStock;
        $variant->update();

        $notes = !empty($data['notes']) ? ' (' . htmlspecialchars($data['notes']) . ')' : '';
        flash('success', "Added {$quantity} units to variant {$variant->sku}. New stock: {$newStock}.{$notes}");

        $productId = $data['product_id'] ?? $variant->product_id;
        $this->redirect('/admin/products/' . $productId);
    }
}
