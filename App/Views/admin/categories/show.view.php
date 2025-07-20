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
    <table class="min-w-full bg-gradient-to-br from-white via-blue-50 to-purple-50 shadow-2xl rounded-2xl border border-blue-100">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-blue-800 font-bold uppercase tracking-wider bg-blue-100">ID</th>
                <th class="px-6 py-3 text-left text-blue-800 font-bold uppercase tracking-wider bg-blue-100">Name</th>
                <th class="px-6 py-3 text-left text-blue-800 font-bold uppercase tracking-wider bg-blue-100">Price</th>
                <th class="px-6 py-3 text-left text-blue-800 font-bold uppercase tracking-wider bg-blue-100">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $i => $product): ?>
                    <tr class="<?= $i % 2 === 0 ? 'bg-white' : 'bg-blue-50' ?> hover:bg-purple-100 transition-colors">
                        <td class="px-6 py-4 font-mono text-blue-900"><?= e($product['id']) ?></td>
                        <td class="px-6 py-4 text-gray-900"><?= e($product['name']) ?></td>
                        <td class="px-6 py-4 text-green-700 font-semibold">MVR <?= e(number_format($product['price'], 2)) ?></td>
                        <td class="px-6 py-4 text-gray-600"><?= e($product['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 bg-white rounded-b-2xl">No products found in this category.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>