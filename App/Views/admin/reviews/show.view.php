<div class="container mx-auto px-4 py-8 max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Review Details</h1>
    <?php if (!$review): ?>
        <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-4">Review not found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <span class="text-gray-600 font-semibold">Name:</span>
                <span class="text-gray-900 font-medium"><?= e($review->name) ?></span>
            </div>
            <div class="mb-4">
                <span class="text-gray-600 font-semibold">Rating:</span>
                <span class="text-yellow-500 font-bold"><?= e($review->rating) ?></span>
            </div>
            <div class="mb-4">
                <span class="text-gray-600 font-semibold">Review:</span>
                <div class="text-gray-800 bg-gray-50 rounded p-2 mt-1 border border-gray-100 text-base"><?= nl2br(e($review->review)) ?></div>
            </div>
            <div class="mb-4">
                <span class="text-gray-600 font-semibold">Submitted:</span>
                <span class="text-gray-700"><?= e($review->created_at ?? '-') ?></span>
            </div>
            <a href="<?= url('admin/reviews') ?>" class="text-blue-600 hover:underline">Back to Reviews</a>
        </div>
    <?php endif; ?>
</div>