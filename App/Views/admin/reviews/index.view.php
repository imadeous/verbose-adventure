<div class="max-w-full">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Reviews</h1>
    <?php if (!empty($report['data'])): ?>
        <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 mb-8">
            <?php foreach ($report['data'] as $stats): ?>
                <?php foreach ($stats as $key => $value): ?>
                    <div class="flex flex-col items-center justify-center h-24 bg-blue-50 rounded-lg shadow border border-blue-100 p-2">
                        <span class="text-xs font-semibold text-blue-900 mb-1 text-center">
                            <?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?>
                        </span>
                        <span class="text-xl font-extrabold text-blue-700 text-center">
                            <?= is_numeric($value) ? number_format($value, 2) : htmlspecialchars($value) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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
                            <span class="w-4 h-4 rounded-full border-4 border-blue-400 bg-white shadow absolute left-5 top-8"></span>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-yellow-400">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                                </svg>
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-blue-200">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                                <span class="text-xs text-blue-400 bg-blue-100 px-2 py-1 rounded-r"><?= e(date('F j, Y', strtotime($review->created_at))) ?></span>
                            </div>
                            <div class="text-blue-800 text-sm wrap-break-word bg-blue-50 px-4 py-3 border border-blue-100 mt-2 rounded-lg shadow-sm" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>