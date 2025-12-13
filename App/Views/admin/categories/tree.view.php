<div class="w-full max-w-full px-2 sm:px-4 py-6 mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-blue-900 mb-1">Category Tree</h1>
            <p class="text-gray-600 text-sm">Interactive hierarchy of all categories, products, and variants</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= url('admin/categories') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold shadow border border-gray-300 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to List
            </a>
            <a href="<?= url('admin/categories/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Category
            </a>
        </div>
    </div>

    <!-- Tree View Container -->
    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6" x-data="categoryTree()">

        <?php if (empty($categories)): ?>
            <!-- Empty State -->
            <div class="py-20 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">No categories found</p>
                <p class="text-gray-400 text-sm mt-1">Create your first category to get started</p>
                <a href="<?= url('admin/categories/create') ?>" class="inline-flex items-center gap-2 mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Category
                </a>
            </div>
        <?php else: ?>
            <!-- Tree Structure -->
            <div class="space-y-1 font-mono text-sm">

                <!-- Root: Catalog (Static, Non-collapsible) -->
                <div class="flex items-center gap-2 py-2 px-3 bg-linear-to-r from-purple-50 to-blue-50 rounded-lg border-l-4 border-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-purple-600 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span class="font-bold text-purple-900 text-base">📚 Product Catalog</span>
                    <span class="ml-auto text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded-full"><?= count($categories) ?> categories</span>
                </div>

                <!-- Categories (Non-collapsible, always shown) -->
                <?php foreach ($categories as $categoryIndex => $category): ?>
                    <div class="ml-6 space-y-1">

                        <!-- Category Node -->
                        <div class="flex items-center gap-2 py-2 px-3 bg-blue-50 hover:bg-blue-100 rounded-lg border-l-4 border-blue-400 transition group">
                            <span class="text-blue-400 shrink-0">└─</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                            <span class="font-semibold text-blue-900"><?= e($category['name']) ?></span>
                            <span class="ml-auto text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full"><?= count($category['products']) ?> products</span>

                            <!-- Category Actions -->
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="<?= url('admin/categories/' . $category['id'] . '/edit') ?>" class="p-1.5 hover:bg-blue-200 rounded transition" title="Edit Category">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Products (Collapsible) -->
                        <div class="ml-8 space-y-1">

                            <?php if (empty($category['products'])): ?>
                                <!-- Add Product Button (when no products) -->
                                <div class="flex items-center gap-2 py-2 px-3 hover:bg-green-50 rounded-lg transition group">
                                    <span class="text-gray-300 shrink-0">└─</span>
                                    <a href="<?= url('admin/products/create?category_id=' . $category['id']) ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span class="text-sm">Add Product</span>
                                    </a>
                                </div>
                            <?php else: ?>

                                <?php foreach ($category['products'] as $productIndex => $product): ?>
                                    <div class="space-y-1">

                                        <!-- Product Node (Collapsible) -->
                                        <div class="flex items-center gap-2 py-2 px-3 bg-amber-50 hover:bg-amber-100 rounded-lg transition group">
                                            <span class="text-amber-400 shrink-0">
                                                <?= $productIndex === count($category['products']) - 1 ? '└─' : '├─' ?>
                                            </span>

                                            <!-- Expand/Collapse Button -->
                                            <button
                                                @click="toggleProduct('<?= $category['id'] ?>-<?= $product['id'] ?>')"
                                                class="shrink-0 hover:bg-amber-200 rounded p-0.5 transition">
                                                <svg x-show="!expandedProducts['<?= $category['id'] ?>-<?= $product['id'] ?>']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                </svg>
                                                <svg x-show="expandedProducts['<?= $category['id'] ?>-<?= $product['id'] ?>']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-600 shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                            <span class="font-medium text-amber-900"><?= e($product['name']) ?></span>
                                            <span class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded-full"><?= count($product['variants']) ?> variants</span>

                                            <!-- Product Actions -->
                                            <div class="ml-auto flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                                <a href="<?= url('admin/products/' . $product['id']) ?>" class="p-1.5 hover:bg-amber-200 rounded transition" title="View Product">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-700">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </a>
                                                <a href="<?= url('admin/products/' . $product['id'] . '/edit') ?>" class="p-1.5 hover:bg-amber-200 rounded transition" title="Edit Product">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-700">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Variants (Collapsible, nested under Product) -->
                                        <div x-show="expandedProducts['<?= $category['id'] ?>-<?= $product['id'] ?>']" x-transition class="ml-8 space-y-1">

                                            <?php if (empty($product['variants'])): ?>
                                                <!-- Add Variant Button (when no variants) -->
                                                <div class="flex items-center gap-2 py-2 px-3 hover:bg-green-50 rounded-lg transition">
                                                    <span class="text-gray-300 shrink-0">└─</span>
                                                    <a href="<?= url('admin/products/' . $product['id']) ?>#variants" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                        <span class="text-sm">Add Variant</span>
                                                    </a>
                                                </div>
                                            <?php else: ?>

                                                <?php foreach ($product['variants'] as $variantIndex => $variant): ?>
                                                    <!-- Variant Node -->
                                                    <div class="flex items-center gap-2 py-2 px-3 bg-teal-50 hover:bg-teal-100 rounded-lg transition group">
                                                        <span class="text-teal-400 shrink-0">
                                                            <?= $variantIndex === count($product['variants']) - 1 ? '└─' : '├─' ?>
                                                        </span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-teal-600 shrink-0">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                                        </svg>
                                                        <span class="text-teal-900 text-sm font-medium">SKU: <?= e($variant['sku']) ?></span>
                                                        <?php if (!empty($variant['color'])): ?>
                                                            <div class="w-4 h-4 rounded border border-gray-300 shadow-sm" style="background-color: <?= e($variant['color']) ?>;" title="<?= e($variant['color']) ?>"></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($variant['dimensions'])): ?>
                                                            <span class="text-xs text-gray-600">• <?= e($variant['dimensions']) ?></span>
                                                        <?php endif; ?>
                                                        <span class="text-xs text-teal-600">MVR <?= number_format($variant['price'], 2) ?></span>
                                                        <span class="text-xs text-gray-500">Stock: <?= $variant['stock_quantity'] ?></span>

                                                        <!-- Variant Actions -->
                                                        <div class="ml-auto flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                                            <a href="<?= url('admin/products/' . $product['id']) ?>#variant-<?= $variant['id'] ?>" class="p-1.5 hover:bg-teal-200 rounded transition" title="Edit Variant">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-teal-700">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                                <!-- Add Variant Button (after existing variants) -->
                                                <div class="flex items-center gap-2 py-2 px-3 hover:bg-green-50 rounded-lg transition">
                                                    <span class="text-gray-300 shrink-0">└─</span>
                                                    <a href="<?= url('admin/products/' . $product['id']) ?>#variants" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                        <span class="text-sm">Add Variant</span>
                                                    </a>
                                                </div>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Add Product Button (after existing products) -->
                                <div class="flex items-center gap-2 py-2 px-3 hover:bg-green-50 rounded-lg transition">
                                    <span class="text-gray-300 shrink-0">└─</span>
                                    <a href="<?= url('admin/products/create?category_id=' . $category['id']) ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span class="text-sm">Add Product</span>
                                    </a>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function categoryTree() {
        return {
            expandedProducts: {},

            toggleProduct(productKey) {
                this.expandedProducts[productKey] = !this.expandedProducts[productKey];
            }
        }
    }
</script>