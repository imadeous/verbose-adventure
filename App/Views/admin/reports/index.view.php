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
        <h2 class="text-xl font-semibold text-blue-900 mb-4">Transactions Report</h2>
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
</div>