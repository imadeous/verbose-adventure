<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Image Gallery -->
            <div class="lg:w-1/2 w-full" x-data="{ 
                currentImage: 0,
                images: <?= json_encode(array_map(function ($img) {
                            return $img['image_url'];
                        }, $images)) ?>
            }">
                <!-- Main Image -->
                <div class="relative h-96 rounded-lg overflow-hidden mb-4">
                    <?php if (!empty($images)): ?>
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                x-show="currentImage === index"
                                :alt="'<?= htmlspecialchars($product['name'] ?? 'Product') ?> - Image ' + (index + 1)"
                                class="w-full h-full object-cover object-center"
                                :src="image">
                        </template>
                    <?php else: ?>
                        <img alt="<?= htmlspecialchars($product['name'] ?? 'Product') ?>"
                            class="w-full h-full object-cover object-center"
                            src="https://dummyimage.com/600x400/1f2937/9ca3af?text=No+Image">
                    <?php endif; ?>
                </div>

                <!-- Thumbnail Gallery -->
                <?php if (count($images) > 1): ?>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        <?php foreach ($images as $index => $image): ?>
                            <button
                                @click="currentImage = <?= $index ?>"
                                :class="currentImage === <?= $index ?> ? 'border-yellow-500' : 'border-gray-700'"
                                class="flex-shrink-0 w-20 h-20 border-2 rounded-lg overflow-hidden hover:border-yellow-400 transition">
                                <img src="<?= htmlspecialchars($image['image_url']) ?>"
                                    alt="Thumbnail <?= $index + 1 ?>"
                                    class="w-full h-full object-cover">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <!-- Breadcrumb -->
                <h2 class="text-sm title-font text-gray-500 tracking-widest mb-1">
                    <?= strtoupper(htmlspecialchars($categoryName ?? 'GENERAL')) ?>
                </h2>

                <!-- Product Name -->
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?>
                </h1>

                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($overallRating)): ?>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php elseif ($i - $overallRating < 1 && $i - $overallRating > 0): ?>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <defs>
                                        <linearGradient id="half-star">
                                            <stop offset="50%" stop-color="currentColor" />
                                            <stop offset="50%" stop-color="#374151" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="text-gray-400 ml-3"><?= number_format($overallRating, 1) ?> (<?= $reviewCount ?> review<?= $reviewCount !== 1 ? 's' : '' ?>)</span>
                    </div>
                </div>

                <!-- Description -->
                <p class="leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'No description available.')) ?>
                </p>

                <!-- Variants -->
                <?php if ($hasVariants && !empty($variants)): ?>
                    <div class="border-t border-gray-800 pt-4 mb-4">
                        <h3 class="text-white text-lg font-medium mb-3">Available Options</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <?php foreach ($variants as $variant): ?>
                                <div class="border border-gray-700 rounded-lg p-3 hover:border-yellow-500 transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-white font-medium"><?= htmlspecialchars($variant['name']) ?></h4>
                                            <?php if (!empty($variant['description'])): ?>
                                                <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($variant['description']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-yellow-500 text-xl font-bold">$<?= number_format($variant['price'], 2) ?></span>
                                            <?php if ($variant['stock'] > 0): ?>
                                                <p class="text-xs text-green-400">In Stock (<?= $variant['stock'] ?>)</p>
                                            <?php else: ?>
                                                <p class="text-xs text-red-400">Out of Stock</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($priceRange): ?>
                            <p class="text-sm text-gray-500 mt-3">
                                Price range: $<?= number_format($priceRange['min'], 2) ?> - $<?= number_format($priceRange['max'], 2) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="flex gap-4 mt-6">
                    <a href="<?= url('/quote') ?>" class="flex-1 text-white bg-yellow-500 border-0 py-3 px-6 focus:outline-none hover:bg-yellow-600 rounded text-center font-medium transition">
                        Request Quote
                    </a>
                    <a href="<?= url('/gallery') ?>" class="flex-1 text-gray-400 bg-gray-800 border border-gray-700 py-3 px-6 focus:outline-none hover:bg-gray-700 hover:text-white rounded text-center font-medium transition">
                        Back to Gallery
                    </a>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <?php if (!empty($reviews)): ?>
            <div class="mt-16 border-t border-gray-800 pt-10">
                <h2 class="text-2xl font-medium text-white mb-8">Customer Reviews</h2>
                <div class="space-y-6">
                    <?php foreach ($reviews as $review): ?>
                        <div class="bg-gray-800 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="flex">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review['rating']): ?>
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="ml-3 text-sm text-gray-400">
                                        <?= htmlspecialchars($review['customer_name'] ?? 'Anonymous') ?>
                                    </span>
                                </div>
                                <?php if (!empty($review['created_at'])): ?>
                                    <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-300 leading-relaxed">
                                <?= nl2br(htmlspecialchars($review['review_text'])) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>