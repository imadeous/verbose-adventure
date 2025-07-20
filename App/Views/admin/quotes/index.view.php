<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quotes</h1>
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($quotes)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No quotes found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($quotes as $quote): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                <a href="<?= url('admin/quotes/' . $quote->id) ?>" class="hover:underline">
                                    <?= e($quote->id) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= e($quote->name) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= e($quote->email) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= e($quote->product_type) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= e($quote->created_at ?? '-') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-2">
                                <a href="<?= url('admin/quotes/' . $quote->id) ?>" class="text-blue-600 hover:underline">View</a>
                                <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this quote?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>