<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Orders Received</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php /* Example: echo number_format($Order->row_count(...), 0); */ ?>
                0
            </dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Revenue</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php /* Example: echo "MVR " . number_format(...); */ ?>
                MVR 0.00
            </dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Avg. Revenue</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                <?php /* Example: echo number_format(...); */ ?>
                0.00
            </dd>
        </div>
    </dl>
</div>
<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Business Insights</h3>
</div>
<div class="grid grid-cols-min lg:grid-cols-3 gap-6">
    <div class="col-span-1 lg:col-span-2 p-4 h-96 bg-white text-sm shadow-lg rounded-lg">
        <!-- Chart placeholder -->
    </div>
    <div class="col-span-1 h-96 px-10 py-8 text-sm shadow-lg rounded-lg bg-white">
        <h1 class="font-semibold">
            <?php echo date('Y') ?> Quarterly Report
        </h1>
        <!-- Chart placeholder -->
    </div>
</div>