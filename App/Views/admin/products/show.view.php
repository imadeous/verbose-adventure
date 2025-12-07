<?php

use App\Models\Product;
?>
<div class="max-w-full space-y-10">
    <!-- Top Section: 2 Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8 md:gap-8 w-full">
        <!-- Card 1: Product Details -->
        <div class="col-span-2 bg-blue-50 rounded-xl shadow-md flex flex-col gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="flex items-center gap-4 mb-2 px-5 pt-5">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Product icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-blue-900">Product Details</h1>
            </div>
            <div class="md:flex items-center justify-between">
                <div class="flex flex-col gap-2 px-5">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Name</span>
                        <span class="text-lg font-bold text-blue-900"><?= e($product->name) ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Category</span>
                        <span class="text-blue-900"><?= e(Product::getCategoryName($product->category_id)) ?></span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Description</span>
                        <span class="text-blue-800"><?= e($product->description) ?></span>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-4 gap-4 flex-wrap">
                    <?php if (!empty($gallery)): ?>
                        <div x-data="{ active: 0 }" class="relative w-64 h-40 flex items-center justify-center">
                            <!-- Images -->
                            <?php foreach ($gallery as $idx => $image): ?>
                                <img
                                    src="<?= url('storage/product/' . e($image['image_url'])) ?>"
                                    alt="<?= e($product->name) ?>"
                                    class="absolute inset-0 w-full h-full object-cover rounded-lg shadow-md border border-blue-100 transition duration-300"
                                    x-show="active === <?= $idx ?>"
                                    x-transition.opacity />
                            <?php endforeach; ?>
                            <!-- Prev Button -->
                            <button
                                type="button"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-blue-100 text-blue-700 rounded-full p-1 shadow hover:bg-blue-200"
                                x-show="<?= count($gallery) ?> > 1"
                                @click="active = active === 0 ? <?= count($gallery) ?> - 1 : active - 1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <!-- Next Button -->
                            <button
                                type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-100 text-blue-700 rounded-full p-1 shadow hover:bg-blue-200"
                                x-show="<?= count($gallery) ?> > 1"
                                @click="active = active === <?= count($gallery) ?> - 1 ? 0 : active + 1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <!-- Dots -->
                            <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-2">
                                <?php foreach ($gallery as $idx => $image): ?>
                                    <button
                                        type="button"
                                        class="w-2 h-2 rounded-full <?= $idx === 0 ? 'bg-blue-400' : 'bg-blue-200' ?>"
                                        :class="active === <?= $idx ?> ? 'bg-blue-400' : 'bg-blue-200'"
                                        @click="active = <?= $idx ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="text-blue-400">No product images uploaded.</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex gap-3 mt-2 justify-end items-center p-5 bg-white rounded-b-xl">
                <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-3 py-1 font-semibold transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </a>
                <a href="<?= url('admin/products/' . $product->id . '/addImage') ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-3 py-1 font-semibold transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </a>
                <form action="<?= url('admin/products/' . $product->id . '/delete') ?>" method="POST" style="display:inline;">
                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm hover:cursor-pointer" onclick="return confirm('Delete this product?')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <!-- Card 2: Stats (Stacked) -->
        <div class="flex flex-col gap-5">
            <!-- Orders Card -->
            <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Orders icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Orders</div>
                    <div class="text-2xl font-bold text-blue-900"><?= e($productTransactions['Total Orders']) ?></div>
                </div>
            </div>
            <!-- Revenue Card -->
            <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Revenue icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Revenue</div>
                    <div class="text-2xl font-bold text-blue-900"><?= e($productTransactions['Total Revenue']) ?></div>
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
                    <div class="text-2xl font-bold text-blue-900">
                        <?= isset($stats['overall_rating']) ? e(number_format($stats['overall_rating'], 1)) : 'N/A' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Variants Section -->
    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6" x-data="variantManager()">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-blue-900">Product Variants</h2>
            </div>
            <button @click="showForm = !showForm"
                type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span x-text="showForm ? 'Cancel' : 'Add Variant'"></span>
            </button>
        </div>

        <!-- Inline Variant Form -->
        <div x-show="showForm"
            x-transition
            class="mb-6 bg-blue-50 rounded-lg border border-blue-200 p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">New Variant</h3>

            <form action="<?= url('admin/products/' . $product->id . '/variants') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Dimensions -->
                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                        <input type="text"
                            name="dimensions"
                            id="dimensions"
                            placeholder="e.g., 2x3x8 cm, 8&quot; wingspan"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (grams)</label>
                        <input type="number"
                            name="weight"
                            id="weight"
                            min="0"
                            placeholder="150"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>

                    <!-- Material -->
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                        <input type="text"
                            name="material"
                            id="material"
                            placeholder="e.g., PLA, Resin, Wood"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color"
                                x-model="colorValue"
                                class="h-10 w-12 rounded border border-blue-300 cursor-pointer">
                            <input type="text"
                                name="color"
                                id="color"
                                x-model="colorValue"
                                placeholder="#000000"
                                pattern="^#[0-9A-Fa-f]{6}$"
                                class="flex-1 rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                        </div>
                    </div>

                    <!-- Finishing -->
                    <div>
                        <label for="finishing" class="block text-sm font-medium text-gray-700 mb-1">Finishing</label>
                        <input type="text"
                            name="finishing"
                            id="finishing"
                            placeholder="e.g., raw print, sanded, painted"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Price <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input type="number"
                                name="price"
                                id="price"
                                step="0.01"
                                min="0"
                                required
                                placeholder="0.00"
                                class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 pl-8 pr-3 py-2 text-sm bg-white">
                        </div>
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text"
                            name="sku"
                            id="sku"
                            placeholder="PROD-001-BLK-SM"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                        <input type="number"
                            name="stock_quantity"
                            id="stock_quantity"
                            min="0"
                            value="0"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-3 py-2 text-sm bg-white">
                    </div>
                </div>

                <!-- Assembly Required -->
                <div class="mb-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox"
                            name="assembly_required"
                            value="1"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Assembly Required</span>
                    </label>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Add Variant
                    </button>
                    <button type="button"
                        @click="showForm = false"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <?php
        $variants = $product->getVariants();
        if (empty($variants)):
        ?>
            <div x-show="!showForm" class="text-center py-12 bg-blue-50 rounded-lg border border-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-blue-400 mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                </svg>
                <p class="text-gray-600 mb-4">No variants created yet</p>
                <button type="button"
                    @click="showForm = true"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Create First Variant
                </button>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($variants as $variant):
                    $variantObj = new \App\Models\Variant((array)$variant);
                ?>
                    <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="text-2xl font-bold text-blue-900 mb-1">
                                    $<?= number_format($variant->price, 2) ?>
                                </div>
                                <?php if (!empty($variant->sku)): ?>
                                    <div class="text-xs text-gray-500">SKU: <?= e($variant->sku) ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($variant->color)): ?>
                                <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm"
                                    style="background-color: <?= e($variantObj->getColorHex()) ?>"></div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2 text-sm mb-4">
                            <?php if (!empty($variant->dimensions)): ?>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                    </svg>
                                    <span><?= e($variant->dimensions) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($variant->weight)): ?>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                                    </svg>
                                    <span><?= e($variantObj->getFormattedWeight()) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($variant->material)): ?>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>
                                    <span><?= e($variant->material) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($variant->finishing)): ?>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                                    </svg>
                                    <span><?= e($variant->finishing) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($variantObj->requiresAssembly()): ?>
                                <div class="flex items-center gap-2 text-orange-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                                    </svg>
                                    <span>Assembly Required</span>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($variant->stock_quantity)): ?>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    <span>Stock: <?= e($variant->stock_quantity) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex gap-2 pt-3 border-t border-blue-200">
                            <a href="<?= url('admin/products/' . $product->id . '/variants/' . $variant->id . '/edit') ?>"
                                class="flex-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-3 py-1.5 text-sm font-semibold text-center transition">
                                Edit
                            </a>
                            <form action="<?= url('admin/products/' . $product->id . '/variants/' . $variant->id . '/delete') ?>"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Delete this variant?')">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="w-full bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1.5 text-sm font-semibold transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Transactions Table: spans 2 columns -->
        <div class="md:col-span-2">
            <!-- Card 3: Transactions Table -->
            <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
                <table class="min-w-full bg-white rounded-xl text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">productname & Email</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Role</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-blue-400">No transactions found for this product.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div class="font-semibold text-blue-900"><?= e($transaction->customer_name) ?></div>
                                        <div class="text-blue-500 text-xs"><?= e($transaction->customer_email) ?></div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($transaction->role ?? 'Customer') ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                                        <a href="<?= url('admin/transactions/' . $transaction->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9m7.5 0v10.5A2.25 2.25 0 0 1 13.5 21h-3A2.25 2.25 0 0 1 8.25 19.5V9m7.5 0H8.25m7.5 0a2.25 2.25 0 0 1 2.25 2.25v7.5A2.25 2.25 0 0 1 15.75 21H8.25A2.25 2.25 0 0 1 6 19.5v-7.5A2.25 2.25 0 0 1 8.25 9h7.5z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Product Reviews: spans 1 column -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6 h-full flex flex-col">
                <h2 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    Product Reviews
                </h2>
                <?php $reviews = Product::getReviews($product->id) ?>
                <?php if (empty($reviews)): ?>
                    <div class="text-blue-400 text-center py-8">No reviews yet for this product.</div>
                <?php else: ?>
                    <div class="flex flex-col gap-4">
                        <?php foreach ($reviews as $review): ?>
                            <div class="border border-blue-100 rounded-lg p-3 bg-blue-50">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-blue-900"><?= e($review['customer_name']) ?></span>
                                    <span class="text-xs text-blue-500"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                                </div>
                                <div class="flex items-center gap-1 mb-1">
                                    <?php $reviewRating = Product::getOverallRating($review['id']); ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <svg class="w-4 h-4 <?= $i <= $reviewRating ? 'text-yellow-400' : 'text-blue-200' ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.049 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z" />
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                                <div class="text-blue-800"><?= e($review['comments']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function variantManager() {
        return {
            showForm: false,
            editingId: null,
            colorValue: '#000000'
        }
    }
</script>