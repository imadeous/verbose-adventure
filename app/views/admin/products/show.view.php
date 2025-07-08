<?php

use Core\Controller;

Controller::start('title'); ?>
Product Details: <?= e($product->title) ?>
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight"><?= e($title ?? 'Product Details') ?></h2>
            <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Product
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 font-semibold">Product Title</p>
                    <p><?= e($product->title) ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Price</p>
                    <p>$<?= e(number_format($product->price, 2)) ?></p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-600 font-semibold">Description</p>
                    <p><?= e($product->description) ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">SKU</p>
                    <p><?= e($product->sku) ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Unit</p>
                    <p><?= e($product->unit) ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Created At</p>
                    <p><?= date('F j, Y, g:i a', strtotime($product->created_at)) ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Last Updated</p>
                    <p><?= date('F j, Y, g:i a', strtotime($product->updated_at)) ?></p>
                </div>
            </div>
            <div class="mt-8 border-t pt-6 flex justify-between items-center">
                <form action="<?= url('admin/products/' . $product->id) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <?= csrf_field() ?>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete Product
                    </button>
                </form>
                <a href="<?= url('admin/products') ?>" class="text-blue-500 hover:text-blue-700">Back to Products</a>
            </div>
        </div>
    </div>
</div>
<?php Controller::end(); ?>