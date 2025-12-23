<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold text-blue-900">Transactions</h1>
        <?php if (App\Helpers\Auth::isAdmin()): ?>
            <div class="flex gap-1 sm:gap-2">
                <a href="<?= url('admin/transactions/income/create') ?>" class="bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm md:text-base px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-lg font-semibold shadow border border-green-700 transition whitespace-nowrap">
                    <span class="hidden sm:inline">+ Add </span>Income
                </a>
                <a href="<?= url('admin/transactions/expense/create') ?>" class="bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm md:text-base px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-lg font-semibold shadow border border-red-700 transition whitespace-nowrap">
                    <span class="hidden sm:inline">+ Add </span>Expense
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-8 bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-blue-900 mb-4">Transactions this Month</h2>
            <form action="<?= url('admin/transactions') ?>" method="GET" class="flex items-center">
                <label for="limit" class="mr-2">Show:</label>
                <select name="limit" id="limit" class="border border-blue-300 rounded-md p-2" onchange="this.form.submit()">
                    <option value="5" <?= ($paginator->perPage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= ($paginator->perPage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($paginator->perPage == 25) ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($paginator->perPage == 50) ? 'selected' : '' ?>>50</option>
                </select>
            </form>
        </div>

        <table class="min-w-full bg-white rounded-xl text-sm overflow-x-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Amount</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">SKU</th>
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
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <?= htmlspecialchars($transaction->date ?? date('Y-m-d')) ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap font-semibold <?= ($transaction->type ?? '') === 'income' ? 'text-green-600' : 'text-red-600'; ?>">
                                MVR <?= number_format((float)($transaction->amount ?? 0), 2) ?>
                            </td>
                            <td class="px-4 py-2 max-w-xs truncate">
                                <?= htmlspecialchars($transaction->description ?: '-') ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden md:table-cell">
                                <?php
                                if ($transaction->type === 'income' && !empty($transaction->variant_id)) {
                                    $variant = \App\Models\Variant::find($transaction->variant_id);
                                    echo htmlspecialchars($variant ? $variant->sku : '-');
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden lg:table-cell">
                                <?php if (!empty($transaction->quote_id)): ?>
                                    <a href="<?= url('admin/quotes/' . $transaction->quote_id) ?>" class="text-blue-600 hover:underline">#<?= htmlspecialchars($transaction->quote_id) ?></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden lg:table-cell">
                                <?php if (!empty($transaction->promo_code_id)): ?>
                                    #<?= htmlspecialchars($transaction->promo_code_id) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden">
                                <a href="<?= url('admin/transactions/show/' . $transaction->id) ?>" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full mt-4">
            <div class="mb-4">
                <p class="text-sm text-gray-600">Showing page <?= $paginator->currentPage ?> of <?= $paginator->totalPages ?>, total transactions: <?= $paginator->totalCount ?></p>
            </div>
            <div class="overflow-x-auto">
                <nav class="mb-4">
                    <ul class="flex space-x-2">
                        <?php
                        // Build query string for pagination links to preserve filters
                        $queryParams = $_GET;
                        unset($queryParams['page']); // Remove page parameter to set it fresh
                        $queryString = http_build_query($queryParams);
                        $baseUrl = url('admin/transactions') . ($queryString ? '?' . $queryString . '&page=' : '?page=');
                        ?>
                        <?php for ($i = 1; $i <= $paginator->totalPages; $i++): ?>
                            <li>
                                <a href="<?= $baseUrl . $i ?>" class="px-3 py-2 rounded-md text-sm font-medium <?= ($i == $paginator->currentPage) ? 'bg-blue-600 text-white' : 'text-blue-700 hover:bg-blue-50' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>