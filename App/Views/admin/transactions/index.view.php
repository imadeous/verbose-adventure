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
                    <!-- all -->
                    <option value="1000" <?= ($paginator->perPage == 1000) ? 'selected' : '' ?>>All</option>
                </select>
            </form>
        </div>

        <table class="min-w-full bg-white rounded-xl text-sm overflow-x-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Amount</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden lg:table-cell">Customer</th>
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
                            <td class="px-4 py-2 max-w-xs truncate hidden md:table-cell">
                                <?= htmlspecialchars($transaction->description ?: '-') ?>
                            </td>
                            <td class="px-4 py-2 hidden lg:table-cell">
                                <?php if (!empty($transaction->customer_username)): ?>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($transaction->customer_username) ?></span>
                                        <?php if (!empty($transaction->platform)): ?>
                                            <span class="text-xs text-gray-500"><?= htmlspecialchars(ucfirst($transaction->platform)) ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <?php
                                if ($transaction->type === 'income' && !empty($transaction->variant_id)) {
                                    $variant = \App\Models\Variant::find($transaction->variant_id);
                                    echo htmlspecialchars($variant ? $variant->sku : '-');
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= url('admin/transactions/' . $transaction->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="<?= url('admin/transactions/' . $transaction->id . '/delete') ?>" method="POST" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm hover:cursor-pointer" title="Delete" onclick="return confirm('Delete this transaction?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
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