<?php

use App\Models\Product;

$variants = Product::getVariants($product->id);
$overallRating = Product::getOverallRating($product->id);
$priceRange = Product::getPriceRange($product->id);
$lowestPrice = Product::getLowestPrice($product->id);
$highestPrice = Product::getHighestPrice($product->id);
?>

<div class="space-y-6">
    <!-- Product Information Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-blue-100 text-blue-600 rounded-lg p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900"><?= e($product->name) ?></h2>
                <p class="text-sm text-gray-500 mt-1"><?= e(Product::getCategoryName($product->category_id)) ?></p>
            </div>

            <!-- Overall Rating Badge -->
            <?php if ($overallRating > 0): ?>
                <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-yellow-500">
                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900"><?= number_format($overallRating, 1) ?></div>
                        <div class="text-xs text-gray-500">Rating</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Details -->
            <div>
                <div class="space-y-4">
                    <!-- Price Range -->
                    <?php if (!empty($variants)): ?>
                        <div class="bg-linear-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                            <label class="text-sm font-medium text-green-700 mb-2 block">Price Range</label>
                            <?php if ($lowestPrice !== null && $highestPrice !== null && $lowestPrice == $highestPrice): ?>
                                <div class="text-3xl font-bold text-green-900">
                                    $<?= number_format($lowestPrice, 2) ?>
                                </div>
                            <?php elseif ($lowestPrice !== null && $highestPrice !== null): ?>
                                <div class="flex items-baseline gap-2">
                                    <div class="text-3xl font-bold text-green-900">
                                        $<?= number_format($lowestPrice, 2) ?>
                                    </div>
                                    <div class="text-lg text-green-600">-</div>
                                    <div class="text-3xl font-bold text-green-900">
                                        $<?= number_format($highestPrice, 2) ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 italic">No pricing available</p>
                            <?php endif; ?>
                            <p class="text-xs text-green-600 mt-1"><?= count($variants) ?> variant<?= count($variants) != 1 ? 's' : '' ?> available</p>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900 mt-1"><?= e($product->description) ?></p>
                    </div>

                    <?php if (!empty($productTransactions)): ?>
                        <div class="pt-4 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-500 mb-3 block">Sales Performance</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-xs text-blue-600 mb-1">Total Orders</p>
                                    <p class="text-2xl font-bold text-blue-900"><?= e($productTransactions['Total Orders'] ?? 0) ?></p>
                                </div>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <p class="text-xs text-green-600 mb-1">Total Revenue</p>
                                    <p class="text-2xl font-bold text-green-900">$<?= number_format($productTransactions['Total Revenue'] ?? 0, 2) ?></p>
                                </div>
                            </div>

                            <!-- Sales Chart -->
                            <?php if (!empty($salesData['data']['datasets']) && !empty($salesData['data']['labels'])): ?>
                                <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <label class="text-xs font-medium text-gray-500 mb-2 block">Sales Trend (Last <?= count($salesData['data']['labels']) ?> Days)</label>
                                    <div class="relative" style="height: 200px;">
                                        <canvas id="salesChart"></canvas>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const ctx = document.getElementById('salesChart');
                                        if (ctx) {
                                            const chartConfig = <?= json_encode($salesData) ?>;
                                            new Chart(ctx, chartConfig);
                                        }
                                    });
                                </script>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Images -->
            <div>
                <?php if (!empty($gallery)): ?>
                    <div x-data="{ active: 0 }" class="space-y-3">
                        <!-- Main Image -->
                        <div class="relative h-64 bg-gray-100 rounded-lg overflow-hidden">
                            <?php foreach ($gallery as $idx => $image): ?>
                                <img
                                    src="/<?= e($image['image_url']) ?>"
                                    alt="<?= e($product->name) ?>"
                                    class="absolute inset-0 w-full h-full object-cover"
                                    x-show="active === <?= $idx ?>"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100">
                            <?php endforeach; ?>

                            <?php if (count($gallery) > 1): ?>
                                <!-- Navigation Buttons -->
                                <button
                                    @click="active = active === 0 ? <?= count($gallery) - 1 ?> : active - 1"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </button>
                                <button
                                    @click="active = active === <?= count($gallery) - 1 ?> ? 0 : active + 1"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Thumbnails -->
                        <?php if (count($gallery) > 1): ?>
                            <div class="flex gap-2 overflow-x-auto">
                                <?php foreach ($gallery as $idx => $image): ?>
                                    <button
                                        @click="active = <?= $idx ?>"
                                        class="shrink-0 w-16 h-16 rounded border-2 transition overflow-hidden"
                                        :class="active === <?= $idx ?> ? 'border-blue-500' : 'border-gray-300 hover:border-gray-400'">
                                        <img
                                            src="/<?= e($image['image_url']) ?>"
                                            alt="Thumbnail <?= $idx + 1 ?>"
                                            class="w-full h-full object-cover">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                        <p class="text-gray-400">No images available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Product Variants Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6" x-data="variantManager()">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-purple-100 text-purple-600 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Product Variants</h2>
            </div>
            <button
                @click="showForm = !showForm"
                type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span x-text="showForm ? 'Cancel' : 'Add Variant'"></span>
            </button>
        </div>

        <!-- Variant Form (Hidden by default) -->
        <div x-show="showForm" x-transition class="mb-6 bg-gray-50 rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">New Variant</h3>

            <form action="<?= url('admin/products/' . $product->id . '/variants') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <!-- Price (Required) -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Price ($) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            step="0.01"
                            min="0"
                            required
                            placeholder="0.00"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input
                            type="text"
                            name="sku"
                            id="sku"
                            placeholder="e.g., PROD-001-BLK"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input
                            type="number"
                            name="stock_quantity"
                            id="stock_quantity"
                            min="0"
                            value="0"
                            placeholder="0"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Dimensions -->
                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                        <input
                            type="text"
                            name="dimensions"
                            id="dimensions"
                            placeholder="e.g., 10x5x3 cm, 8&quot; wingspan"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (grams)</label>
                        <input
                            type="number"
                            name="weight"
                            id="weight"
                            min="0"
                            placeholder="0"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Material -->
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                        <input
                            type="text"
                            name="material"
                            id="material"
                            placeholder="e.g., Wood, Metal, Plastic"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <div class="flex gap-2">
                            <input
                                type="color"
                                name="color"
                                id="color"
                                x-model="colorValue"
                                class="h-10 w-16 rounded border-gray-300 cursor-pointer">
                            <input
                                type="text"
                                x-model="colorValue"
                                placeholder="#000000"
                                maxlength="7"
                                pattern="^#[0-9A-Fa-f]{6}$"
                                class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                        </div>
                    </div>

                    <!-- Finishing -->
                    <div>
                        <label for="finishing" class="block text-sm font-medium text-gray-700 mb-1">Finishing</label>
                        <input
                            type="text"
                            name="finishing"
                            id="finishing"
                            placeholder="e.g., Glossy, Matte, Polished"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Assembly Required Checkbox -->
                <div class="mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            name="assembly_required"
                            value="1"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Assembly Required</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                        Add Variant
                    </button>
                    <button
                        type="button"
                        @click="showForm = false"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Variants List -->
        <?php if (empty($variants)): ?>
            <div x-show="!showForm" class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-gray-400 mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                </svg>
                <p class="text-gray-600 mb-4">No variants created yet</p>
                <button
                    type="button"
                    @click="showForm = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Create First Variant
                </button>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dimensions</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Weight</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Material</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Color</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Finishing</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($variants as $v):
                            $variantObj = new \App\Models\Variant((array)$v);
                        ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-lg font-bold text-gray-900">
                                        $<?= number_format($variantObj->price ?? 0, 2) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-700"><?= e($variantObj->sku ?: '—') ?></span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-700"><?= e($variantObj->dimensions ?: '—') ?></span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">
                                        <?= $variantObj->weight ? $variantObj->getFormattedWeight() : '—' ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-gray-700"><?= e($variantObj->material ?: '—') ?></span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php if ($variantObj->color): ?>
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded border border-gray-300"
                                                style="background-color: <?= e($variantObj->getColorHex()) ?>"></div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <?php if ($variantObj->finishing): ?>
                                            <span class="text-sm text-gray-700"><?= e($variantObj->finishing) ?></span>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-400">—</span>
                                        <?php endif; ?>
                                        <?php if ($variantObj->assembly_required): ?>
                                            <span class="inline-flex items-center gap-1 text-xs text-amber-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                                </svg>
                                                Assembly
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $variantObj->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= e($variantObj->stock_quantity) ?> in stock
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            @click="openStockModal(<?= $variantObj->id ?>, '<?= e($variantObj->sku) ?>', <?= $variantObj->stock_quantity ?>)"
                                            class="text-green-600 hover:text-green-700 transition p-1.5 hover:bg-green-50 rounded"
                                            title="Add stock">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </button>
                                        <form action="<?= url('admin/products/' . $product->id . '/variants/' . $variantObj->id . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this variant?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition p-1.5 hover:bg-red-50 rounded" title="Delete variant">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
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
        <?php endif; ?>
    </div>

    <!-- Add Stock Modal -->
    <?php include __DIR__ . '/../../partials/admin/add-stock-modal.php'; ?>

    <!-- Reviews Section -->
    <?php if (!empty($reviews)): ?>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-yellow-100 text-yellow-600 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Customer Reviews</h2>
                    <?php if ($overallRating > 0): ?>
                        <p class="text-sm text-gray-600">
                            Average rating: <span class="font-semibold"><?= number_format($overallRating, 1) ?></span> / 5.0
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-4">
                <?php foreach ($reviews as $review): ?>
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1">
                                <?php
                                $reviewRating = is_array($review) ? ($review['rating'] ?? 0) : ($review->rating ?? 0);
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <svg class="w-4 h-4 <?= $i <= $reviewRating ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.049 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-gray-500">
                                <?php
                                $createdAt = is_array($review) ? ($review['created_at'] ?? null) : ($review->created_at ?? null);
                                echo $createdAt ? date('M d, Y', strtotime($createdAt)) : 'N/A';
                                ?>
                            </span>
                        </div>
                        <p class="text-gray-700">
                            <?php
                            $comments = is_array($review) ? ($review['comments'] ?? '') : ($review->comments ?? '');
                            echo e($comments);
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function variantManager() {
        return {
            showForm: false,
            colorValue: '#000000',
            showStockModal: false,
            selectedVariant: {
                id: null,
                sku: '',
                currentStock: 0
            },
            stockQuantity: 0,

            openStockModal(variantId, sku, currentStock) {
                this.selectedVariant = {
                    id: variantId,
                    sku: sku,
                    currentStock: currentStock
                };
                this.stockQuantity = 0;
                this.showStockModal = true;
            },

            closeStockModal() {
                this.showStockModal = false;
                this.selectedVariant = {
                    id: null,
                    sku: '',
                    currentStock: 0
                };
                this.stockQuantity = 0;
            }
        }
    }
</script>