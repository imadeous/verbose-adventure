<?php

use Core\Controller;

Controller::start('title');
?>
<?= e($title) ?>
<?php
Controller::end();
Controller::start('content');
?>
<!-- Hero section -->
<div class="relative isolate overflow-hidden">
    <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true">
        <defs>
            <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1"
                patternUnits="userSpaceOnUse">
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-800/20">
            <path
                d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z"
                stroke-width="0" />
        </svg>
        <rect width="100%" height="100%" stroke-width="0"
            fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
    </svg>
    <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]"
        aria-hidden="true">
        <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-20"
            style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)">
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-40 lg:flex lg:px-8 lg:pt-40">
        <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
            <img class="h-32" src="/assets/img/brand.png" alt="Your Company">
            <h1 class="mt-10 text-4xl font-bold tracking-tight text-white sm:text-6xl">Welcome to the world
                of Craftophiles</h1>
            <p class="mt-6 text-lg leading-8 text-gray-300">
                In the heart of Craftophile, we are more than a business;
                we are a collective of passionate artisans. <br>
                Our ethos, 'Artificium est vita nostra' defines our very being.
            </p>
            <div class="mt-10 flex items-center gap-x-6">
                <a href="order.php"
                    class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">Order
                    Now!</a>
                <a href="https://www.instagram.com/craftophile_mv"
                    class="text-sm font-semibold leading-6 text-white">Instagram <span
                        aria-hidden="true">→</span></a>
            </div>
        </div>
        <div
            class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
            <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none overflow-hidden">
                <img src="https://images.unsplash.com/photo-1611117775350-ac3950990985?q=80&w=1771&auto=format&fit=crop&ixlib=rb-4.0.3"
                    alt="App screenshot" width="2432" height="1442"
                    class="w-[76rem] rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10">
            </div>
        </div>
    </div>
</div>

<!-- Logo cloud -->
<div class="mx-auto mt-8 max-w-7xl px-6 sm:mt-16 lg:px-8">
    <h2 class="text-center text-lg font-semibold leading-8 text-white">Our Services</h2>
    <div
        class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
        <?php foreach ($categories as $category) : ?>
            <h2 class="text-center text font-semibold leading-8 text-white">
                <?php echo $category->title; ?>
            </h2>
        <?php endforeach; ?>
    </div>
</div>
<?php Controller::end(); ?>

<!-- Products List -->
<div class="mx-auto mt-16 max-w-7xl px-6 lg:px-8">
    <h2 class="text-center text-lg font-semibold leading-8 text-white mb-8">Our Products</h2>
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                    <?php if (!empty($product->image_url)) : ?>
                        <img src="<?= e($product->image_url) ?>" alt="<?= e($product->title) ?>" class="h-32 w-32 object-cover rounded mb-4">
                    <?php endif; ?>
                    <h3 class="text-xl font-bold text-white mb-2"><?= e($product->title) ?></h3>
                    <p class="text-gray-300 text-center mb-4"><?= e($product->description ?? '') ?></p>
                    <?php if (isset($product->price)) : ?>
                        <span class="text-indigo-400 font-semibold text-lg mb-2">$<?= e(number_format($product->price, 2)) ?></span>
                    <?php endif; ?>
                    <a href="#" class="mt-auto inline-block rounded bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="col-span-full text-center text-gray-400">No products available at the moment.</p>
        <?php endif; ?>
    </div>
</div>