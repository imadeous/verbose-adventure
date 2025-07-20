<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quotes</h1>
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Name & Email</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($quotes)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">No quotes found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($quotes as $quote): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="font-semibold text-gray-800"><?= e($quote->name) ?></div>
                                <div class="text-gray-500 text-xs"><?= e($quote->email) ?></div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700"><?= e($quote->product_type) ?></td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-500 text-xs"><?= e($quote->created_at ?? '-') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="<?= url('admin/quotes/' . $quote->id) ?>" class="text-blue-600 hover:underline">View</a>
                                    <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this quote?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>