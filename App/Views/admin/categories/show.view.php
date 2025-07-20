<h1 class="text-3xl font-extrabold mb-8 text-gray-900 tracking-tight">Category Details</h1>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Category Details -->
    <div class="bg-gradient-to-br from-blue-50 to-white shadow-xl rounded-2xl p-8 border border-blue-100">
        <div class="mb-4 flex items-center space-x-3">
            <span class="inline-block bg-blue-100 text-blue-600 rounded-full px-3 py-1 text-xs font-bold">ID: <?= e($category->id) ?></span>
            <span class="inline-block bg-green-100 text-green-600 rounded-full px-3 py-1 text-xs font-bold"><?= e($category->created_at) ?></span>
        </div>
        <div class="mb-2">
            <span class="block text-lg font-semibold text-gray-700">Name</span>
            <span class="text-2xl font-bold text-gray-900"><?= e($category->name) ?></span>
        </div>
    </div>
    <!-- Category Stats -->
    <div class="bg-gradient-to-br from-purple-50 to-white shadow-xl rounded-2xl p-8 border border-purple-100 flex flex-col space-y-6">
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium text-gray-600">Product Count</span>
            <span class="text-xl font-bold text-purple-700"><?= isset($stats['product_count']) ? e($stats['product_count']) : count($products) ?></span>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium text-gray-600">Total Revenue</span>
            <span class="text-xl font-bold text-green-700">
                $<?= isset($stats['total_revenue']) ? e(number_format($stats['total_revenue'], 2)) : '0.00' ?>
            </span>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium text-gray-600">Overall Rating</span>
            <span class="text-xl font-bold text-yellow-500">
                <?= isset($stats['overall_rating']) ? e(number_format($stats['overall_rating'], 1)) : 'N/A' ?>
            </span>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold mb-4 text-gray-800">Products in this Category</h2>
<div class="overflow-x-auto">
    <?php if (!empty($products)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 flex flex-col hover:shadow-2xl transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-blue-600 bg-blue-100 rounded-full px-3 py-1">ID: <?= e($product['id']) ?></span>
                        <span class="text-xs text-gray-500"><?= e(date('F j, Y', strtotime($product['created_at']))) ?></span>
                    </div>
                    <div class="mb-3 flex justify-center">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" class="h-32 w-32 object-cover rounded-xl border border-gray-200 shadow-sm" />
                        <?php else: ?>
                            <div class="h-32 w-32 flex items-center justify-center bg-gray-100 rounded-xl text-gray-400 text-4xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-1"><?= e($product['name']) ?></h3>
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-3"><?= e($product['description']) ?></p>
                        <?php endif; ?>
                        <p class="text-green-700 font-semibold text-xl mt-auto">MVR <?= e(number_format($product['price'], 2)) ?></p>
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