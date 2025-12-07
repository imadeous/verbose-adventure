<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Image Gallery -->
            <div class="lg:w-1/2 w-full" x-data="{ 
                currentImage: 0,
                images: <?php
                        echo json_encode(array_map(function ($img) {
                            return $img['image_url'];
                        }, $images));
                        ?>
            }">
                <!-- Main Image -->
                <div class="relative h-96 rounded-lg overflow-hidden mb-4">
                    <?php if (!empty($images)): ?>
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                x-show="currentImage === index"
                                :alt="'<?= htmlspecialchars($product->name ?? 'Product') ?> - Image ' + (index + 1)"
                                class="w-full h-full object-cover object-center"
                                :src="image">
                        </template>
                    <?php else: ?>
                        <img alt="<?= htmlspecialchars($product->name ?? 'Product') ?>"
                            class="w-full h-full object-cover object-center"
                            src="https://dummyimage.com/600x400/1f2937/9ca3af?text=No+Image">
                    <?php endif; ?>
                </div>

                <div>
                    <img alt="<?= htmlspecialchars($product->name ?? 'Product') ?>"
                        class="w-full h-full object-cover object-center"
                        src="https://dummyimage.com/600x400/1f2937/9ca3af?text=No+Image">
                </div>

                <!-- Thumbnail Navigation -->
                <?php if (count($images) > 1): ?>
                    <div class="flex gap-2 overflow-x-auto">
                        <template x-for="(image, index) in images" :key="index">
                            <button
                                @click="currentImage = index"
                                :class="currentImage === index ? 'ring-2 ring-indigo-500' : ''"
                                class="shrink-0 w-20 h-20 rounded overflow-hidden focus:outline-none">
                                <img :src="image"
                                    :alt="'Thumbnail ' + (index + 1)"
                                    class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Information -->
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest mb-1">
                    <?= htmlspecialchars($product->getCategoryName($product->category_id) ?? 'General') ?>
                </h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product->name ?? 'Product Name') ?>
                </h1>
                <p class="leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($product->description ?? 'No description available.')) ?>
                </p>

                <!-- Price and Variants -->
                <?php if ($hasVariants && !empty($variants)): ?>
                    <div class="mb-6">
                        <h3 class="text-white text-lg font-medium mb-3">Available Options:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($variants as $variant): ?>
                                <div class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition-all">
                                    <?php if (!empty($variant['image'])): ?>
                                        <div class="h-40 overflow-hidden">
                                            <img src="<?= htmlspecialchars($variant['image']) ?>"
                                                alt="<?= htmlspecialchars($variant['sku'] ?? 'Variant') ?>"
                                                class="w-full h-full object-cover">
                                        </div>
                                    <?php endif; ?>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-white font-medium"><?= htmlspecialchars($variant['sku'] ?? 'N/A') ?></h4>
                                                <?php if (!empty($variant['dimensions'])): ?>
                                                    <p class="text-gray-400 text-sm"><?= htmlspecialchars($variant['dimensions']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-indigo-400 font-semibold text-lg">
                                                $<?= number_format($variant['price'] ?? 0, 2) ?>
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-2 text-xs">
                                            <?php if (!empty($variant['material'])): ?>
                                                <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded"><?= htmlspecialchars($variant['material']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($variant['color'])): ?>
                                                <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded flex items-center gap-1">
                                                    <span class="w-3 h-3 rounded-full" style="background-color: <?= htmlspecialchars($variant['color']) ?>"></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!empty($variant['finishing'])): ?>
                                                <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded"><?= htmlspecialchars($variant['finishing']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3 flex justify-between items-center">
                                            <span class="text-sm <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'text-green-400' : 'text-red-400' ?>">
                                                <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'In Stock (' . $variant['stock_quantity'] . ')' : 'Out of Stock' ?>
                                            </span>
                                            <?php if ($variant['assembly_required'] ?? false): ?>
                                                <span class="text-xs text-yellow-400">⚙️ Assembly Required</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-3xl font-medium text-white">
                                $<?= number_format($product->price ?? 0, 2) ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>