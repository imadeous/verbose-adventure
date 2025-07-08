<?php

use Core\Controller;

Controller::start('title');
?>
Admin Dashboard
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Orders Received</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php
                // this will return the row count of Orders where timestamp is within past 30 days
                // echo number_format($Order->row_count('timestamp', '<=', date("Y-m-d 00:00:00", strtotime('-30 days'))), 0);
                echo '1,234';
                ?>
            </dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Revenue</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php
                // echo "MVR " . number_format($Order->calculate('price', 'sum', [['status', '=', 'paid'], ['timestamp', '<=', date("Y-m-d 00:00:00", strtotime('-30 days'))]]), 2);
                echo 'MVR 54,321.00';
                ?>
            </dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Avg. Revenue</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php
                // echo number_format($Order->calculate('price', 'avg', [['status', '=', 'paid'], ['timestamp', '<=', date("Y-m-d 00:00:00", strtotime('-30 days'))]]), 2);
                echo '43.21';
                ?>
            </dd>
        </div>
    </dl>
</div>
<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Business Insights</h3>
</div>

<!-- Chart Grid -->
<div class="grid grid-cols-min lg:grid-cols-3 gap-6">
    <div class="col-span-1 lg:col-span-2 p-4 h-96 bg-white text-sm shadow-lg rounded-lg">
        <canvas id="mymonthlyChart"></canvas>
    </div>
    <div class="col-span-1 h-96 px-10 py-8 text-sm shadow-lg rounded-lg bg-white">
        <h1 class="font-semibold">
            <?php echo date('Y') ?> Quarterly Report
        </h1>
        <canvas id="myQuarterlyChart"></canvas>
    </div>

</div>
<!-- End of Chart Grid -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Sales Chart
        const monthlyCtx = document.getElementById('mymonthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5, 2, 3, 7, 8, 9, 10, 11, 12],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Quarterly Sales Chart
        const quarterlyCtx = document.getElementById('myQuarterlyChart').getContext('2d');
        new Chart(quarterlyCtx, {
            type: 'doughnut',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{
                    label: 'Sales',
                    data: [300, 50, 100, 80],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>
<?php Controller::end(); ?>