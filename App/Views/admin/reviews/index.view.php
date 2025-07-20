<div class="container mx-auto px-4 py-8 max-w-3xl">
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
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">#<?= e($review->id) ?></span>
                                <span class="font-semibold text-gray-800"><?= e($review->customer_name) ?></span>
                                <span class="ml-2 flex items-center text-yellow-500 font-medium">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review->quality_rating): ?>
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36" />
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="ml-1 text-xs text-gray-500"><?= e($review->quality_rating) ?>/5</span>
                                </span>
                            </div>
                            <div class="text-gray-700 text-sm break-words bg-gray-50 px-3 py-2 rounded" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0 flex space-x-2">
                            <a href="<?= url('admin/reviews/' . $review->id) ?>" class="inline-flex items-center px-3 py-1 border border-blue-500 text-blue-600 rounded hover:bg-blue-50 text-sm transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View
                            </a>
                            <form action="<?= url('admin/reviews/' . $review->id . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this review?')" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-500 text-red-600 rounded hover:bg-red-50 text-sm transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>