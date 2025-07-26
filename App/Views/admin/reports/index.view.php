<div class="max-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-900">Reports</h1>
        <nav class="text-sm text-blue-700">
            <?php if (!empty($breadcrumb)): ?>
                <?php foreach ($breadcrumb as $i => $crumb): ?>
                    <?php if (!empty($crumb['url'])): ?>
                        <a href="<?= htmlspecialchars($crumb['url']) ?>" class="hover:underline"><?= htmlspecialchars($crumb['label']) ?></a>
                        <?php if ($i < count($breadcrumb) - 1): ?> &raquo; <?php endif; ?>
                    <?php else: ?>
                        <span><?= htmlspecialchars($crumb['label']) ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="" method="get" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="period_start" class="block text-sm font-medium text-blue-900">Period Start</label>
                <input type="date" name="period_start" id="period_start" value="<?= htmlspecialchars($_GET['period_start'] ?? date('Y-m-01')) ?>" class="border rounded-lg px-2 py-1 text-sm w-40">
            </div>
            <div>
                <label for="period_end" class="block text-sm font-medium text-blue-900">Period End</label>
                <input type="date" name="period_end" id="period_end" value="<?= htmlspecialchars($_GET['period_end'] ?? date('Y-m-t')) ?>" class="border rounded-lg px-2 py-1 text-sm w-40">
            </div>
            <div>
                <label for="grouping" class="block text-sm font-medium text-blue-900">Grouping Period</label>
                <select name="grouping" id="grouping" class="border rounded-lg px-2 py-1 text-sm">
                    <?php foreach (
                        [
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                            'monthly' => 'Monthly',
                            'quarterly' => 'Quarterly',
                            'yearly' => 'Yearly'
                        ] as $key => $label
                    ): ?>
                        <option value="<?= $key ?>" <?= (($_GET['grouping'] ?? 'daily') === $key) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-blue-900">Type</label>
                <select name="type" id="type" class="border rounded-lg px-2 py-1 text-sm">
                    <option value="all" <?= (($_GET['type'] ?? 'all') === 'all') ? 'selected' : '' ?>>All</option>
                    <option value="income" <?= (($_GET['type'] ?? '') === 'income') ? 'selected' : '' ?>>Income</option>
                    <option value="expense" <?= (($_GET['type'] ?? '') === 'expense') ? 'selected' : '' ?>>Expense</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-blue-900">Aggregates</label>
                <div class="flex gap-2">
                    <label><input type="checkbox" name="aggregate_sum" value="1" <?= !empty($_GET['aggregate_sum']) ? 'checked' : '' ?>> Sum</label>
                    <label><input type="checkbox" name="aggregate_avg" value="1" <?= !empty($_GET['aggregate_avg']) ? 'checked' : '' ?>> Average</label>
                    <label><input type="checkbox" name="aggregate_min" value="1" <?= !empty($_GET['aggregate_min']) ? 'checked' : '' ?>> Min</label>
                    <label><input type="checkbox" name="aggregate_max" value="1" <?= !empty($_GET['aggregate_max']) ? 'checked' : '' ?>> Max</label>
                </div>
            </div>
            <div>
                <label for="title" class="block text-sm font-medium text-blue-900">Report Title</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($_GET['title'] ?? 'Transactions Report') ?>" class="border rounded-lg px-2 py-1 text-sm w-56">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Update Report</button>
        </form>
        <h2 class="text-xl font-semibold text-blue-900 mb-4"><?= htmlspecialchars($_GET['title'] ?? 'Transactions Report') ?></h2>
        <?php if (!empty($report) && !empty($report['data'])): ?>
            <table class="min-w-full bg-white rounded-xl text-sm">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Total Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Max Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report['data'] as $row): ?>
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['period_day'] ?? '-') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= number_format($row['Total'] ?? 0, 2) ?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= number_format($row['Max'] ?? 0, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-blue-400">No report data available for this period.</p>
        <?php endif; ?>
    </div>
    <pre>
        <?= htmlspecialchars(json_encode($report, JSON_PRETTY_PRINT)) ?>
    </pre>
</div>