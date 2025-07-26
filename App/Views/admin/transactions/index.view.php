<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Transactions</h1>
        <?php if (App\Helpers\Auth::isAdmin()): ?>
            <a href="<?= url('admin/transactions/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Add Transaction</a>
        <?php endif; ?>
    </div>
    <?php if (!empty($report['data'])): ?>
        <pre>
            <strong>Report Data:</strong>
            <?= htmlspecialchars(json_encode($report, JSON_PRETTY_PRINT)) ?>
        </pre>
    <?php endif; ?>
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
    make a report card for $dailyReport looping through $dailyReport['data'] if it exists
    <?php if (!empty($dailyReport['data'])): ?>
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-blue-900 mb-4">Daily Report</h2>
            <table class="min-w-full bg-white rounded-xl text-sm">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Total Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Max Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Min Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Average Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dailyReport['data'] as $day): ?>
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2"><?= htmlspecialchars(date('Y-m-d', strtotime($day['period_day']))) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(number_format($day['Total'], 2)) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(number_format($day['Max'], 2)) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(number_format($day['Min'], 2)) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(number_format($day['Average'], 2)) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars(number_format($day['Count'], 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>