<?php

use App\Models\Product; ?>

<div class="max-w-8xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-blue-900">Products</h1>
        <a href="<?= url('admin/products/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Add Product</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Product</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Orders</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Revenue</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Variants</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Stock</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Stock Value</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No products found.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($products as $product): ?>
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900"><?= e($product->name) ?></span>
                                <span class="text-xs text-gray-500"><?= e(Product::getCategoryName($product->category_id)) ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= e($product->total_orders) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if ($product->total_revenue === 0): ?>
                                <span class="text-gray-400">-</span>
                            <?php else: ?>
                                <span class="font-semibold text-green-700">
                                    <span class="text-xs">MVR </span><?= number_format($product->total_revenue, 2) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <?= e($product->variant_count) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $product->total_stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= e($product->total_stock) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if (isset($product->stock_value) && $product->stock_value > 0): ?>
                                <span class="font-semibold text-blue-700">
                                    <span class="text-xs">MVR </span><?= number_format($product->stock_value, 2) ?>
                                    <?php
                                    var_dump($product->stock_value);
                                    ?>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?= url('admin/products/' . $product->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <form action="<?= url('admin/products/' . $product->id . '/delete') ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm hover:cursor-pointer" title="Delete" onclick="return confirm('Delete this product?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>