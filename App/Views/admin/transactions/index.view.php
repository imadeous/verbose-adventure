<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Transactions</h1>
        <?php if (App\Helpers\Auth::isAdmin()): ?>
            <a href="<?= url('admin/transactions/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Add Transaction</a>
        <?php endif; ?>
    </div>
    <table class="min-w-full bg-white rounded-xl text-sm">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Amount</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Category</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Quote ID</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Promo Code ID</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
                <tr>
                    <td colspan="10" class="px-4 py-4 text-center text-blue-400">No transactions found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($transactions as $transaction): ?>
                    <tr class="<?= ($transaction->type ?? '') === 'income' ? 'bg-green-100' : 'bg-red-100'; ?> border-t border-blue-100 hover:bg-blue-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($transaction->date ?? '-') ?></td>
                        <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($transaction->amount ?? '-') ?></td>
                        <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($transaction->category_name ?? '-') ?></td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <?php if (!empty($transaction->quote_id)): ?>
                                <a href="<?= url('admin/quotes/' . $transaction->quote_id) ?>"><?= htmlspecialchars($transaction->quote_id) ?></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($transaction->promo_code_id ?? '-') ?></td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <a href="<?= url('admin/transactions/show/' . $transaction->id) ?>" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Report</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($report['data'])): ?>
                <tr>
                    <td class="px-4 py-4 text-center text-blue-400">No report data available.</td>
                </tr>
            <?php else: ?>
                <tr>
                    <?php foreach ($report['columns'] as $col => $label): ?>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">
                            <?= htmlspecialchars($label) ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($report['data'] as $row): ?>
                    <tr>
                        <?php foreach ($report['columns'] as $col => $label): ?>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <?= htmlspecialchars($row[$col] ?? '-') ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
    </table>
</div>