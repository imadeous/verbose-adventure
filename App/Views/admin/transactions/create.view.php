<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Add Transaction</h1>
    <?php if (!empty($breadcrumb)): ?>
        <nav class="mb-4 text-xs text-blue-600">
            <?php foreach ($breadcrumb as $i => $item): ?>
                <?php if (!empty($item['url'])): ?>
                    <a href="<?= $item['url'] ?>" class="hover:underline"><?= htmlspecialchars($item['label']) ?></a>
                <?php else: ?>
                    <span><?= htmlspecialchars($item['label']) ?></span>
                <?php endif; ?>
                <?php if ($i < count($breadcrumb) - 1): ?> &raquo; <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
    <form action="<?= url('admin/transactions/store') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Type</label>
            <select name="type" class="w-full border border-blue-300 rounded-lg px-3 py-2" required>
                <option value="">Select Type</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Category</label>
            <input type="text" name="category" class="w-full border border-blue-300 rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Amount</label>
            <input type="number" name="amount" step="0.01" class="w-full border border-blue-300 rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Description</label>
            <input type="text" name="description" class="w-full border border-blue-300 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Quote ID</label>
            <input type="number" name="quote_id" class="w-full border border-blue-300 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Promo Code ID</label>
            <input type="number" name="promo_code_id" class="w-full border border-blue-300 rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Date</label>
            <input type="date" name="date" class="w-full border border-blue-300 rounded-lg px-3 py-2">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700">Add Transaction</button>
        </div>
    </form>
</div>