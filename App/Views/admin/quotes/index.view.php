<div class="max-w-5xl mx-auto p-8">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Quotes</h1>
    <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Name & Email</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Product</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Submitted</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($quotes)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-blue-400">No quotes found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($quotes as $quote): ?>
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="font-semibold text-blue-900"><?= e($quote->name) ?></div>
                                <div class="text-blue-500 text-xs"><?= e($quote->email) ?></div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($quote->product_type) ?></td>
                            <td class="px-4 py-2 whitespace-nowrap text-blue-400 text-xs"><?= e($quote->created_at ?? '-') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="<?= url('admin/quotes/' . $quote->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm">View</a>
                                    <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm" onclick="return confirm('Delete this quote?')">Delete</button>
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