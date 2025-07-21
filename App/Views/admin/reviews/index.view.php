<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Reviews</h1>
    <?php if (empty($reviews)): ?>
        <div class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-4 py-3 rounded-lg mb-6">No reviews found.</div>
    <?php else: ?>
        <div class="relative">
            <div class="absolute left-6 top-0 bottom-0 w-1 bg-blue-100 rounded-full"></div>
            <ul class="space-y-0">
                <?php foreach ($reviews as $i => $review): ?>
                    <li class="relative flex items-start group">
                        <!-- Timeline dot -->
                        <div class="z-10 flex flex-col items-center">
                            <span class="w-4 h-4 rounded-full border-4 border-blue-400 bg-white shadow absolute left-3 top-8"></span>
                        </div>
                        <!-- Review Card -->
                        <div class="ml-16 flex-1 mb-10">
                            <div class="flex flex-col justify-center items-start space-x-3 mb-2">
                                <div class="flex justify-between items-center">
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
                                <span class="text-xs text-blue-400 bg-blue-100 px-2 py-1 rounded-r"><?= e(date('F j, Y', strtotime($review->created_at))) ?></span>
                            </div>
                            <div class="text-blue-800 text-sm break-words bg-blue-50 px-4 py-3 border border-blue-100 mt-2 rounded-lg shadow-sm" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>