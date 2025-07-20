<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h1>
    <?php if (empty($reviews)): ?>
        <div class="bg-yellow-100 text-yellow-700 border border-yellow-300 px-4 py-3 rounded mb-4">No reviews found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($review->id) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($review->name) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= e($review->rating) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-xs truncate" title="<?= e($review->review) ?>"><?= e($review->review) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?= url('admin/reviews/' . $review->id) ?>" class="text-blue-600 hover:underline mr-2">View</a>
                                <form action="<?= url('admin/reviews/' . $review->id . '/delete') ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this review?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>