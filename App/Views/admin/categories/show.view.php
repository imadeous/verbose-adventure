<h1 class="text-3xl font-extrabold mb-8 text-gray-900 tracking-tight">Category Details</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
    <!-- Category Details Card -->
    <div class="col-span-2 bg-blue-50 rounded-xl shadow-md p-5 flex flex-col gap-4 border border-blue-200 hover:shadow-lg transition">
        <div class="flex items-center gap-4 mb-2">
            <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                <!-- Category icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M6.364 6.364l-1.591 1.591M3 12h2.25m1.114 5.636-1.591 1.591m5.636 1.114V21m5.636-1.114 1.591 1.591m1.114-5.636H21m-1.114-5.636 1.591-1.591M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-blue-900">Category Details</h2>
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">ID</span>
                <span class="text-blue-900 font-semibold"><?= e($category->id) ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Created</span>
                <span class="text-green-700 font-semibold"><?= e($category->created_at) ?></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Name</span>
                <span class="text-lg font-bold text-blue-900"><?= e($category->name) ?></span>
            </div>
        </div>
    </div>
    <!-- Category Stats (Stacked Cards) -->
    <div class="flex flex-col gap-5">
        <!-- Product Count Card -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                <!-- Product count icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Product Count</div>
                <div class="text-2xl font-bold text-blue-900"><?= isset($stats['product_count']) ? e($stats['product_count']) : count($products) ?></div>
            </div>
        </div>
        <!-- Total Revenue Card -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                <!-- Revenue icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Total Revenue</div>
                <div class="text-2xl font-bold text-green-700">
                    $<?= isset($stats['total_revenue']) ? e(number_format($stats['total_revenue'], 2)) : '0.00' ?>
                </div>
            </div>
        </div>
        <!-- Overall Rating Card -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                <!-- Star icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Overall Rating</div>
                <div class="text-2xl font-bold text-yellow-500">
                    <?= isset($stats['overall_rating']) ? e(number_format($stats['overall_rating'], 1)) : 'N/A' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4 text-gray-800">Products in this Category</h2>
<div class="overflow-x-auto">
    <?php if (!empty($products)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 py-6">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-3xl shadow-2xl border border-blue-100 p-6 flex flex-col hover:shadow-3xl transition-all duration-300 group relative overflow-hidden">
                    <!-- Ribbon for featured/new products (optional) -->
                    <?php if (!empty($product['is_featured'])): ?>
                        <span class="absolute top-4 left-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg z-10">Featured</span>
                    <?php endif; ?>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-blue-700 bg-blue-100 rounded-full px-3 py-1">ID: <?= e($product['id']) ?></span>
                        <span class="text-xs text-gray-400"><?= e(date('M j, Y', strtotime($product['created_at']))) ?></span>
                    </div>
                    <div class="mb-4 flex justify-center items-center relative">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" class="h-32 w-32 object-cover rounded-xl border border-gray-200 shadow-md group-hover:scale-105 transition-transform duration-300" />
                        <?php else: ?>
                            <div class="h-32 w-32 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl text-gray-300 text-4xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors"><?= e($product['name']) ?></h3>
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-gray-500 text-sm mb-2 line-clamp-3"><?= e($product['description']) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center justify-between mt-auto">
                            <p class="text-green-700 font-bold text-xl">MVR <?= e(number_format($product['price'], 2)) ?></p>
                            <a href="/admin/products/<?= e($product['id']) ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-full shadow hover:bg-blue-700 transition-colors">
                                View
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-gray-500 bg-white rounded-2xl py-12 shadow-inner">
            No products found in this category.
        </div>
    <?php endif; ?>
</div>