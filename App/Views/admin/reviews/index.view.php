<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h1>
    <?php if (empty($reviews)): ?>
        <div class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-3 rounded mb-4">No reviews found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <ul class="divide-y divide-gray-200">
                <?php foreach ($reviews as $review): ?>
                    <li class="py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 transition">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-r">#<?= e($review->id) ?></span>
                                <span class="font-semibold text-gray-800"><?= e($review->customer_name) ?></span>
                                <span class="ml-2 flex items-center text-yellow-500 font-medium">
                                    <?php
                                    $ratings = [
                                        $review->quality_rating,
                                        $review->pricing_rating,
                                        $review->communication_rating,
                                        $review->packaging_rating,
                                        $review->delivery_rating
                                    ];
                                    $average = round(array_sum($ratings) / count($ratings), 1);
                                    ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $average): ?>
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                            <div class="text-gray-700 text-sm break-words bg-gray-50 px-4 py-3 border border-gray-200 mt-2" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>