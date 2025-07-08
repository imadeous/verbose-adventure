<?php view()->layout('admin'); ?>

<?php

use Core\Controller;
use Helpers\Report;

Controller::start('title'); ?>
Site Analytics
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="flex-1 p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Site Analytics</h1>
        <form method="get" class="flex items-center space-x-2">
            <label class="text-gray-700">From:
                <input type="date" name="start" value="<?= e($start ?? '') ?>" class="form-input ml-1">
            </label>
            <label class="text-gray-700">To:
                <input type="date" name="end" value="<?= e($end ?? '') ?>" class="form-input ml-1">
            </label>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <div class="mb-6">
        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
            Unique Visitors: <?= (int)($uniqueVisitors ?? 0) ?>
        </span>
    </div>

    <!-- Chart -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold mb-4">Page Views Over Time</h2>
        <canvas id="pageViewsChart"></canvas>
    </div>

    <!-- Data Table -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Raw Analytics Data</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Page URL</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Visitor IP</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">User Agent</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Referer</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($data as $row) : ?>
                        <tr class="border-b">
                            <td class="py-3 px-4"><?= htmlspecialchars($row->page_url) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row->visitor_ip ?? 'N/A') ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row->user_agent ?? 'N/A') ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row->referer_url ?? 'N/A') ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row->visit_timestamp) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('pageViewsChart').getContext('2d');
        const chartData = <?= json_encode($chartData) ?>;
        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<?php Controller::end(); ?>

<?php
// Generate a daily grouped report for site analytics
$report = Report::generate(
    'site_analytics',
    'daily',
    $start,
    $end,
    'visit_timestamp',
    'id' // count rows for page views
);

// Prepare Chart.js data (single dataset, no group field needed)
$chartData = [
    'labels' => array_column($report['groups'], 'period'),
    'datasets' => [[
        'label' => 'Page Views',
        'data' => array_column($report['groups'], 'count'),
        'borderColor' => 'rgba(75, 192, 192, 1)',
        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
        'borderWidth' => 2,
        'tension' => 0.3
    ]]
];
