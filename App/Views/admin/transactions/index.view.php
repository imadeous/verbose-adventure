<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Transactions</h1>
    <table class="w-full bg-white rounded shadow border border-blue-100">
        <thead>
            <tr class="bg-blue-50 text-blue-700">
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Type</th>
                <th class="px-4 py-2 text-left">Category</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Description</th>
                <th class="px-4 py-2 text-left">Quote ID</th>
                <th class="px-4 py-2 text-left">Promo Code ID</th>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Created At</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?= $transaction['id'] ?? '-' ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['type'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['category'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['amount'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['description'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['quote_id'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['promo_code_id'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['date'] ?? '-') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($transaction['created_at'] ?? '-') ?></td>
                    <td class="px-4 py-2">
                        <a href="<?= url('admin/transactions/show/' . $transaction['id']) ?>" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>