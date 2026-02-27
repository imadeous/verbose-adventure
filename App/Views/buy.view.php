<?php

use App\Models\Product;
use App\Models\Gallery;

$product = Product::find($variant->product_id);
$Gallery = Gallery::select(['id', 'related_id', 'image_url'])
    ->where('related_id', '=', $variant->id)
    ->andWhere('image_type', '=', 'variant')
    ->get();
?>
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <div class="lg:w-1/2 w-full lg:pr-10 lg:py-6 mb-6 lg:mb-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest"><?= $variant->sku ?? 'N/A' ?></h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">nothing</h1>
                <div class="flex mb-4">
                    <a class="grow text-yellow-400 border-b-2 border-yellow-500 py-2 text-lg px-1">Description</a>
                    <a class="grow border-b-2 border-gray-800 py-2 text-lg px-1">Reviews</a>
                    <a class="grow border-b-2 border-gray-800 py-2 text-lg px-1">Details</a>
                </div>
                <div class="flex border-t border-gray-800 py-2">
                    <span class="text-gray-500">Color</span>
                    <span class="ml-auto text-white">
                        <?php if (!empty($variant->color)): ?>
                            <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full" style="background-color: <?= htmlspecialchars($variant->color) ?>"></span>
                                <span><?= $variant->finishing ?? 'N/A' ?></span>
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="flex border-t border-gray-800 py-2">
                    <span class="text-gray-500">Dimensions</span>
                    <span class="ml-auto text-white"><?= $variant->dimensions ?? 'N/A' ?></span>
                </div>
                <div class="flex border-t border-b mb-6 border-gray-800 py-2">
                    <span class="text-gray-500">Available Stock</span>
                    <span class="ml-auto text-white"><?= $variant->stock_quantity ?? 'N/A' ?></span>
                </div>
                <div class="flex">
                    <span class="title-font font-medium text-2xl text-white"><span class="text-sm text-gray-400 mr-2">MVR</span><?= $variant->price ?? 'N/A' ?></span>
                    <button class="flex ml-auto text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded">Button</button>
                    <button class="rounded-full w-10 h-10 bg-gray-800 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <?php
            foreach ($Gallery as $image) {
                $imageUrl = '/' . $image['image_url'];
                echo '<img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="' . $imageUrl . '">';
            }
            ?>
            <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://dummyimage.com/400x400">
        </div>
    </div>
</section>