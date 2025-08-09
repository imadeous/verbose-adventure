<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Transactions</h1>
        <?php if (App\Helpers\Auth::isAdmin()): ?>
            <a href="<?= url('admin/transactions/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Add Transaction</a>
        <?php endif; ?>
    </div>

    <!-- Dynamic Controls Card -->
    <div class="mt-6 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">Filter Transactions</h3>
        <form action="<?= url('admin/transactions') ?>" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Transaction Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="income" <?= ($_GET['type'] ?? '') === 'income' ? 'selected' : '' ?>>Income</option>
                        <option value="expense" <?= ($_GET['type'] ?? '') === 'expense' ? 'selected' : '' ?>>Expense</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <input type="text" name="category" id="category" value="<?= htmlspecialchars($_GET['category'] ?? '') ?>"
                        placeholder="Search category..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Amount Range -->
                <div>
                    <label for="min_amount" class="block text-sm font-medium text-gray-700 mb-1">Min Amount</label>
                    <input type="number" name="min_amount" id="min_amount" value="<?= htmlspecialchars($_GET['min_amount'] ?? '') ?>"
                        placeholder="0.00" step="0.01"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="max_amount" class="block text-sm font-medium text-gray-700 mb-1">Max Amount</label>
                    <input type="number" name="max_amount" id="max_amount" value="<?= htmlspecialchars($_GET['max_amount'] ?? '') ?>"
                        placeholder="999999.99" step="0.01"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                        Apply Filters
                    </button>
                    <a href="<?= url('admin/transactions') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition">
                        Clear
                    </a>
                </div>
            </div>

            <!-- Hidden field to preserve pagination limit -->
            <input type="hidden" name="limit" value="<?= htmlspecialchars($_GET['limit'] ?? '10') ?>">
        </form>
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
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Category</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Quote ID</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Promo Code ID</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden">Actions</th>
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
                            <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($transaction->date ?? '-') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap font-semibold <?= ($transaction->type ?? '') === 'income' ? 'text-green-600' : 'text-red-600'; ?>">
                                <?= htmlspecialchars($transaction->amount ?? '-') ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden md:table-cell"><?= htmlspecialchars($transaction->category_name ?? '-') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap hidden md:table-cell">
                                <?php if (!empty($transaction->quote_id)): ?>
                                    <a href="<?= url('admin/quotes/' . $transaction->quote_id) ?>"><?= htmlspecialchars($transaction->quote_id) ?></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap hidden md:table-cell"><?= htmlspecialchars($transaction->promo_code_id ?? '-') ?></td>
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