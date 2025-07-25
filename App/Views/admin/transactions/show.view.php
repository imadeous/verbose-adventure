<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Transaction Details</h1>
    <?php if ($transaction): ?>
        <div class="bg-white rounded shadow border border-blue-100 p-6">
            <div class="mb-2"><span class="font-semibold">ID:</span> <?= $transaction['id'] ?? '-' ?></div>
            <div class="mb-2"><span class="font-semibold">Type:</span> <?= htmlspecialchars($transaction['type'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Category:</span> <?= htmlspecialchars($transaction['category'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Amount:</span> <?= htmlspecialchars($transaction['amount'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Description:</span> <?= htmlspecialchars($transaction['description'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Quote ID:</span> <?= htmlspecialchars($transaction['quote_id'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Promo Code ID:</span> <?= htmlspecialchars($transaction['promo_code_id'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Date:</span> <?= htmlspecialchars($transaction['date'] ?? '-') ?></div>
            <div class="mb-2"><span class="font-semibold">Created At:</span> <?= htmlspecialchars($transaction['created_at'] ?? '-') ?></div>
        </div>
    <?php else: ?>
        <div class="text-red-600">Transaction not found.</div>
    <?php endif; ?>
    <div class="mt-6">
        <a href="<?= url('admin/transactions') ?>" class="text-blue-600 hover:underline">Back to Transactions</a>
    </div>
</div>