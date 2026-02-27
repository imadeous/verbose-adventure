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
                <h1 class="text-white text-3xl title-font font-medium mb-4"><?= $product->name ?? 'N/A' ?></h1>
                <div class="flex mb-4">
                    <a class="grow text-yellow-400 border-b-2 border-yellow-500 py-2 text-lg px-1">Description</a>
                    <!-- <a class="grow border-b-2 border-gray-800 py-2 text-lg px-1">Reviews</a>
                    <a class="grow border-b-2 border-gray-800 py-2 text-lg px-1">Details</a> -->
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

<section class="text-gray-400 bg-gray-900 body-font relative">
    <div class="container px-5 py-12 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Fill in your details</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify.</p>
        </div>
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                <div class="p-2 ">
                    <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-400">Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                <div class="p-2">
                    <div class="relative">
                        <label for="email" class="leading-7 text-sm text-gray-400">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                <div class="p-2 w-full">
                    <div class="relative">
                        <label for="message" class="leading-7 text-sm text-gray-400">Message</label>
                        <textarea id="message" name="message" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 h-32 text-base outline-none text-gray-100 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <button class="flex mx-auto text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg">Button</button>
                </div>
                <div class="p-2 w-full pt-8 mt-8 border-t border-gray-800 text-center">
                    <a class="text-yellow-400">example@email.com</a>
                    <p class="leading-normal my-5">49 Smith St.
                        <br>Saint Cloud, MN 56301
                    </p>
                    <span class="inline-flex">
                        <a class="text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a class="ml-4 text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                            </svg>
                        </a>
                        <a class="ml-4 text-gray-500">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>
                        <a class="ml-4 text-gray-500">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>