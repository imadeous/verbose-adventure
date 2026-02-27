<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Image Gallery (All Images: Product + Variants) -->
            <div class="lg:w-1/2 w-full" x-data='<?php
                                                    echo json_encode([
                                                        "currentImage" => 0,
                                                        "images" => array_map(function ($img) {
                                                            return $img["image_url"];
                                                        }, $images)
                                                    ], JSON_HEX_APOS | JSON_HEX_QUOT);
                                                    ?>'>
                <!-- Main Image -->
                <div class="relative h-96 rounded-lg overflow-hidden mb-4">
                    <?php if (!empty($images)): ?>
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                x-show="currentImage === index"
                                x-transition
                                :alt="'<?= htmlspecialchars($product->name ?? 'Product') ?> - Image ' + (index + 1)"
                                class="w-full h-full object-cover object-center absolute inset-0"
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
                    <?= htmlspecialchars($product->getCategoryName($product->category_id) ?? 'General') ?>
                </h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product->name ?? 'Product Name') ?>
                </h1>

                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <?php
                        $rating = $overallRating ?? 5.0;
                        $fullStars = floor($rating);
                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

                        // Full stars
                        for ($i = 0; $i < $fullStars; $i++):
                        ?>
                            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        <?php endfor; ?>

                        <?php // Half star
                        if ($hasHalfStar):
                        ?>
                            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="half">
                                        <stop offset="50%" stop-color="currentColor" />
                                        <stop offset="50%" stop-color="transparent" />
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half)" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        <?php endif; ?>

                        <?php // Empty stars
                        for ($i = 0; $i < $emptyStars; $i++):
                        ?>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <span class="text-gray-400 ml-3"><?= number_format($rating, 1) ?> Rating<?= $reviewCount > 0 ? ' (' . $reviewCount . ' reviews)' : '' ?></span>
                </div>

                <!-- Price Range -->
                <div class="mb-4">
                    <span class="text-3xl font-medium text-white">
                        <?= $priceRange ?>
                    </span>
                </div>

                <p class="leading-relaxed mb-6">
                    <?= nl2br(htmlspecialchars($product->description ?? 'No description available.')) ?>
                </p>
            </div>
        </div>

        <!-- Available Options Section (Moved to Bottom) -->
        <?php if ($hasVariants && !empty($variants)): ?>
            <div class="lg:w-4/5 mx-auto mt-12">
                <h3 class="text-white text-2xl font-medium mb-6">Available Options:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($variants as $variant): ?>
                        <div class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition-all">
                            <?php if (!empty($variant['image'])): ?>
                                <div class="h-48 overflow-hidden">
                                    <img src="<?= htmlspecialchars($variant['image']) ?>"
                                        alt="<?= htmlspecialchars($variant['sku'] ?? 'Variant') ?>"
                                        class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="text-white font-medium text-lg"><?= htmlspecialchars($variant['sku'] ?? 'N/A') ?></h4>
                                        <?php if (!empty($variant['dimensions'])): ?>
                                            <p class="text-gray-400 text-sm"><?= htmlspecialchars($variant['dimensions']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-indigo-400 font-semibold text-xl">
                                        MVR <?= number_format($variant['price'] ?? 0, 2) ?>
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-2 text-xs mt-3">
                                    <?php if (!empty($variant['material'])): ?>
                                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded"><?= htmlspecialchars($variant['material']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($variant['color'])): ?>
                                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded flex items-center gap-1">
                                            <span class="w-3 h-3 rounded-full" style="background-color: <?= htmlspecialchars($variant['color']) ?>"></span>
                                            <?= htmlspecialchars($variant['color']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($variant['finishing'])): ?>
                                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded"><?= htmlspecialchars($variant['finishing']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-sm <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'text-green-400' : 'text-red-400' ?>">
                                        <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'In Stock (' . $variant['stock_quantity'] . ')' : 'Print-on-demand' ?>
                                    </span>
                                    <?php if ($variant['assembly_required'] ?? false): ?>
                                        <span class="text-xs text-yellow-400">⚙️ Assembly Required</span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-4 flex justify-end items-center">
                                    <a href="buy.php" class="px-2 py-1 <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'bg-yellow-500' : 'bg-indigo-700' ?> text-sm text-white rounded hover:bg-indigo-600 transition-colors disabled:opacity-50">
                                        <?= ($variant['stock_quantity'] ?? 0) > 0 ? 'Buy Now' : 'Request' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Customer Reviews Section -->
        <div class="lg:w-4/5 mx-auto mt-12">
            <h3 class="text-white text-2xl font-medium mb-6">Customer Reviews</h3>

            <?php if (!empty($reviews)): ?>
                <div class="space-y-6">
                    <?php foreach ($reviews as $review):
                        $reviewData = is_array($review) ? $review : (array)$review;

                        // Calculate average rating from all rating categories
                        $ratings = [
                            $reviewData['quality_rating'] ?? 0,
                            $reviewData['pricing_rating'] ?? 0,
                            $reviewData['communication_rating'] ?? 0,
                            $reviewData['packaging_rating'] ?? 0,
                            $reviewData['delivery_rating'] ?? 0
                        ];
                        $avgRating = array_sum($ratings) / count(array_filter($ratings));
                    ?>
                        <div class="bg-gray-800 rounded-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h4 class="text-white font-medium"><?= htmlspecialchars($reviewData['customer_name'] ?? 'Anonymous') ?></h4>
                                    <span class="text-gray-500 text-xs"><?= htmlspecialchars($reviewData['created_at'] ?? '') ?></span>
                                </div>
                                <div class="flex gap-6 items-center">
                                    <!-- Overall Rating -->
                                    <div class="text-center">
                                        <div class="flex items-center">
                                            <div class="flex text-yellow-400">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <svg fill="<?= $i < round($avgRating) ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="text-yellow-400 text-sm ml-2 font-semibold"><?= number_format($avgRating, 1) ?></span>
                                        </div>
                                        <span class="text-gray-400 text-xs">Overall Rating</span>
                                    </div>
                                    <!-- Recommendation Percentage -->
                                    <?php if (isset($reviewData['recommendation_score'])):
                                        $recommendPercentage = ($reviewData['recommendation_score'] / 10) * 100;
                                    ?>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold <?= $reviewData['recommendation_score'] >= 8 ? 'text-green-400' : ($reviewData['recommendation_score'] >= 5 ? 'text-yellow-400' : 'text-red-400') ?>">
                                                <?= round($recommendPercentage) ?>%
                                            </div>
                                            <span class="text-gray-400 text-xs">Would Recommend</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!empty($reviewData['comments'])): ?>
                                <p class="text-gray-300 leading-relaxed">
                                    <?= nl2br(htmlspecialchars($reviewData['comments'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-gray-800 rounded-lg p-8 text-center">
                    <p class="text-gray-400">No reviews yet. Be the first to review this product!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- More from this Category Section -->
        <?php if (!empty($relatedProducts)): ?>
            <div class="lg:w-4/5 mx-auto mt-12">
                <h3 class="text-white text-2xl font-medium mb-6">More from this Category</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <a href="<?= url('/product/' . $relatedProduct['id']) ?>" class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition-all group">
                            <?php if (!empty($relatedProduct['image_url'])): ?>
                                <div class="h-48 overflow-hidden">
                                    <img src="<?= htmlspecialchars($relatedProduct['image_url']) ?>"
                                        alt="<?= htmlspecialchars($relatedProduct['name'] ?? 'Product') ?>"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                            <?php else: ?>
                                <div class="h-48 bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h4 class="text-white font-medium mb-2 line-clamp-2"><?= htmlspecialchars($relatedProduct['name'] ?? 'Product') ?></h4>

                                <!-- Rating -->
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <svg fill="<?= $i < round($relatedProduct['overall_rating']) ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-3 h-3" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-gray-400 text-xs ml-2"><?= number_format($relatedProduct['overall_rating'], 1) ?><?= $relatedProduct['review_count'] > 0 ? ' (' . $relatedProduct['review_count'] . ')' : '' ?></span>
                                </div>

                                <!-- Price -->
                                <div class="text-indigo-400 font-semibold"><?= $relatedProduct['price_display'] ?? 'MVR 0.00' ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>