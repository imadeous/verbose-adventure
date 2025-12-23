<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Add Expense</h1>
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
    <form action="<?= url('admin/transactions/expense') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <input type="hidden" name="type" value="expense">

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Amount</label>
            <input type="number"
                name="amount"
                step="0.01"
                class="w-full border border-blue-300 rounded-lg px-3 py-2"
                placeholder="Enter amount"
                required>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Description (optional)</label>
            <textarea name="description" rows="3" class="w-full border border-blue-300 rounded-lg px-3 py-2" placeholder="Enter expense description"></textarea>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Customer Username (optional)</label>
            <input type="text" name="customer_username" class="w-full border border-blue-300 rounded-lg px-3 py-2" placeholder="Enter customer username or identifier">
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Platform (optional)</label>
            <select name="platform" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                <option value="">Select Platform</option>
                <option value="instagram">Instagram</option>
                <option value="tiktok">Tiktok</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="facebook">Facebook</option>
                <option value="website">Website</option>
                <option value="phone">Phone</option>
                <option value="in-person">In Person</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Date</label>
            <input type="date" name="date" class="w-full border border-blue-300 rounded-lg px-3 py-2" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?= url('/admin/transactions') ?>" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold shadow border border-gray-300 hover:bg-gray-300">Cancel</a>
            <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-red-700 hover:bg-red-700">Add Expense</button>
        </div>
    </form>
</div>