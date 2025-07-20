<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h1>
    <?php if (empty($reviews)): ?>
        <div class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-3 rounded mb-4">No reviews found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <ul class="divide-y divide-gray-200">
                <?php foreach ($reviews as $review): ?>
                    <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-xs text-gray-400">#<?= e($review->id) ?></span>
                                <span class="font-semibold text-gray-800"><?= e($review->customer_name) ?></span>
                                <span class="ml-2 text-yellow-500 font-medium"><?= e($review->quality_rating) ?>/5</span>
                            </div>
                            <div class="text-gray-700 text-sm break-words" title="<?= e($review->comments) ?>">
                                <?= e($review->comments) ?>
                            </div>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-4 flex-shrink-0 flex space-x-2">
                            <a href="<?= url('admin/reviews/' . $review->id) ?>" class="text-blue-600 hover:underline text-sm">View</a>
                            <form action="<?= url('admin/reviews/' . $review->id . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this review?')" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>