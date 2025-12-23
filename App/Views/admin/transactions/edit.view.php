<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Edit Transaction #<?= htmlspecialchars($transaction->id) ?></h1>
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

    <form action="<?= url('admin/transactions/' . $transaction->id) ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Type</label>
            <select name="type" class="w-full border border-blue-300 rounded-lg px-3 py-2 bg-gray-100" disabled>
                <option value="income" <?= $transaction->type === 'income' ? 'selected' : '' ?>>Income</option>
                <option value="expense" <?= $transaction->type === 'expense' ? 'selected' : '' ?>>Expense</option>
            </select>
            <input type="hidden" name="type" value="<?= htmlspecialchars($transaction->type) ?>">
            <p class="mt-1 text-xs text-gray-500">Transaction type cannot be changed</p>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Amount</label>
            <input type="number"
                name="amount"
                step="0.01"
                value="<?= htmlspecialchars($transaction->amount) ?>"
                class="w-full border border-blue-300 rounded-lg px-3 py-2"
                required>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Description (optional)</label>
            <textarea name="description" rows="3" class="w-full border border-blue-300 rounded-lg px-3 py-2" placeholder="Enter description"><?= htmlspecialchars($transaction->description ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Customer Username (optional)</label>
            <input type="text" name="customer_username" value="<?= htmlspecialchars($transaction->customer_username ?? '') ?>" class="w-full border border-blue-300 rounded-lg px-3 py-2" placeholder="Enter customer username or identifier">
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Platform (optional)</label>
            <select name="platform" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                <option value="">Select Platform</option>
                <option value="instagram" <?= ($transaction->platform ?? '') === 'instagram' ? 'selected' : '' ?>>Instagram</option>
                <option value="tiktok" <?= ($transaction->platform ?? '') === 'tiktok' ? 'selected' : '' ?>>Tiktok</option>
                <option value="whatsapp" <?= ($transaction->platform ?? '') === 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                <option value="facebook" <?= ($transaction->platform ?? '') === 'facebook' ? 'selected' : '' ?>>Facebook</option>
                <option value="website" <?= ($transaction->platform ?? '') === 'website' ? 'selected' : '' ?>>Website</option>
                <option value="phone" <?= ($transaction->platform ?? '') === 'phone' ? 'selected' : '' ?>>Phone</option>
                <option value="in-person" <?= ($transaction->platform ?? '') === 'in-person' ? 'selected' : '' ?>>In Person</option>
                <option value="other" <?= ($transaction->platform ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div>
            <label class="block text-blue-700 font-semibold mb-1">Date</label>
            <input type="date" name="date" value="<?= htmlspecialchars($transaction->date ?? date('Y-m-d')) ?>" class="w-full border border-blue-300 rounded-lg px-3 py-2" required>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?= url('/admin/transactions') ?>" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold shadow border border-gray-300 hover:bg-gray-300">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 hover:bg-blue-700">Update Transaction</button>
        </div>
    </form>
</div>