<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Image Gallery -->
            <div class="lg:w-1/2 w-full" x-data="{ 
                currentImage: 0,
                images: <?php

                        use App\Models\Product;

                        $images = Product::getImages($product->id);
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
                    <?= htmlspecialchars($product->category_id ?? 'General') ?>
                </h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product->name ?? 'Product Name') ?>
                </h1>
                <p class="leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($product->description ?? 'No description available.')) ?>
                </p>

                <!-- Price and Variants -->
                <?php
                $variants = Product::getVariants($product->id);
                $hasVariants = Product::hasVariants($product->id);
                ?>

                <?php if ($hasVariants && !empty($variants)): ?>
                    <div class="mb-6">
                        <h3 class="text-white text-lg font-medium mb-3">Available Options:</h3>
                        <div class="space-y-2">
                            <?php foreach ($variants as $variant): ?>
                                <div class="flex justify-between items-center p-3 bg-gray-800 rounded-lg">
                                    <div>
                                        <span class="text-white font-medium"><?= htmlspecialchars($variant['sku'] ?? 'N/A') ?></span>
                                        <span class="text-gray-400 text-sm ml-2">
                                            (Stock: <?= $variant['stock_quantity'] ?? 0 ?>)
                                        </span>
                                    </div>
                                    <span class="text-indigo-400 font-semibold">
                                        $<?= number_format($variant['price'] ?? 0, 2) ?>
                                    </span>
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