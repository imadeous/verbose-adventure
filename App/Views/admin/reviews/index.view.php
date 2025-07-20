<div class="max-w-8xl mx-auto p-8">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Reviews</h1>
    <?php if (empty($reviews)): ?>
        <div class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-4 py-3 rounded-lg mb-6">No reviews found.</div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
            <ul class="divide-y divide-blue-100">
                <?php foreach ($reviews as $review): ?>
                    <li class="py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-blue-50 transition">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="text-xs text-blue-400 bg-blue-100 px-2 py-1 rounded-r">#<?= e($review->id) ?></span>
                                <span class="font-semibold text-blue-900"><?= e($review->customer_name) ?></span>
                                <span class="ml-2 flex items-center text-yellow-400 font-medium">
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
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-4 h-4 text-blue-100 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                            <div class="text-blue-800 text-sm break-words bg-blue-50 mx-4 mx-auto px-4 py-3 border border-blue-100 mt-2 rounded-lg" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>