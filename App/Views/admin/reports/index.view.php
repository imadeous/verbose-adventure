<div class="max-full mx-auto" x-data="reportApp()" x-init="init()">
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
        <form @change="fetchReport" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label for="period_start" class="block text-sm font-medium text-blue-900">Period Start</label>
                <input type="date" x-model="period_start" class="border rounded-lg px-2 py-1 text-sm w-40">
            </div>
            <div>
                <label for="period_end" class="block text-sm font-medium text-blue-900">Period End</label>
                <input type="date" x-model="period_end" class="border rounded-lg px-2 py-1 text-sm w-40">
            </div>
            <div>
                <label for="grouping" class="block text-sm font-medium text-blue-900">Grouping Period</label>
                <select x-model="grouping" class="border rounded-lg px-2 py-1 text-sm">
                    <template x-for="(label, key) in groupings" :key="key">
                        <option :value="key" x-text="label"></option>
                    </template>
                </select>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-blue-900">Type</label>
                <select x-model="type" class="border rounded-lg px-2 py-1 text-sm">
                    <option value="all">All</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-blue-900">Aggregates</label>
                <div class="flex gap-2">
                    <label><input type="checkbox" x-model="aggregate_sum"> Sum</label>
                    <label><input type="checkbox" x-model="aggregate_avg"> Average</label>
                    <label><input type="checkbox" x-model="aggregate_min"> Min</label>
                    <label><input type="checkbox" x-model="aggregate_max"> Max</label>
                </div>
            </div>
        </form>
        <template x-if="loading">
            <div class="text-blue-400">Loading report...</div>
        </template>
        <h2 class="text-xl font-semibold text-blue-900 mb-4" x-text="title"></h2>
        <p class="text-sm text-gray-600 mb-4" x-text="caption"></p>
        <template x-if="!loading && report && report.data && report.data.length">
            <table class="min-w-full bg-white rounded-xl text-sm">
                <thead>
                    <tr>
                        <template x-for="(label, key) in columns" :key="key">
                            <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200" x-text="label"></th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="row in report.data" :key="row">
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <template x-for="(label, key) in columns" :key="key">
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <template x-if="['Total','Average','Min','Max'].includes(key)">
                                        <span x-text="Number(row[key] ?? 0).toFixed(2)"></span>
                                    </template>
                                    <template x-if="!['Total','Average','Min','Max'].includes(key)">
                                        <span x-text="row[key] ?? '-'"></span>
                                    </template>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </template>
        <template x-if="!loading && (!report || !report.data || !report.data.length)">
            <p class="text-blue-400">No report data available for this period.</p>
        </template>
        <template x-if="!loading && report">
            <pre x-text="JSON.stringify(report, null, 2)"></pre>
        </template>
    </div>
    <script>
        function reportApp() {
            return {
                period_start: '<?= htmlspecialchars($_GET['period_start'] ?? date('Y-m-01')) ?>',
                period_end: '<?= htmlspecialchars($_GET['period_end'] ?? date('Y-m-t')) ?>',
                grouping: '<?= htmlspecialchars($_GET['grouping'] ?? 'daily') ?>',
                type: '<?= htmlspecialchars($_GET['type'] ?? 'all') ?>',
                aggregate_sum: <?= !empty($_GET['aggregate_sum']) ? 'true' : 'false' ?>,
                aggregate_avg: <?= !empty($_GET['aggregate_avg']) ? 'true' : 'false' ?>,
                aggregate_min: <?= !empty($_GET['aggregate_min']) ? 'true' : 'false' ?>,
                aggregate_max: <?= !empty($_GET['aggregate_max']) ? 'true' : 'false' ?>,
                groupings: {
                    daily: 'Daily',
                    weekly: 'Weekly',
                    monthly: 'Monthly',
                    quarterly: 'Quarterly',
                    yearly: 'Yearly'
                },
                report: null,
                columns: {},
                loading: false,
                init() {
                    this.fetchReport();
                },
                fetchReport() {
                    this.loading = true;
                    const params = new URLSearchParams({
                        period_start: this.period_start,
                        period_end: this.period_end,
                        grouping: this.grouping,
                        type: this.type,
                        aggregate_sum: this.aggregate_sum ? '1' : '',
                        aggregate_avg: this.aggregate_avg ? '1' : '',
                        aggregate_min: this.aggregate_min ? '1' : '',
                        aggregate_max: this.aggregate_max ? '1' : '',
                    });
                    fetch(window.location.pathname + '?' + params.toString())
                        .then(r => r.text())
                        .then(html => {
                            // Parse the HTML and extract the report JSON from the <pre> block
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const pre = doc.querySelector('pre');
                            if (pre) {
                                try {
                                    this.report = JSON.parse(pre.textContent);
                                    // Determine columns
                                    this.columns = {};
                                    if (this.report && this.report.data && this.report.data.length && typeof this.report.data[0] === 'object') {
                                        for (const key in this.report.data[0]) {
                                            if ([
                                                    'period_day', 'period_week', 'period_month', 'period_quarter', 'period_year'
                                                ].includes(key)) {
                                                this.columns[key] = key.replace('period_', '').replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                                            } else if (key === 'Total') {
                                                this.columns[key] = 'Total Amount';
                                            } else if (key === 'Average') {
                                                this.columns[key] = 'Average Amount';
                                            } else if (key === 'Min') {
                                                this.columns[key] = 'Min Amount';
                                            } else if (key === 'Max') {
                                                this.columns[key] = 'Max Amount';
                                            } else {
                                                this.columns[key] = key.charAt(0).toUpperCase() + key.slice(1);
                                            }
                                        }
                                    }
                                } catch (e) {
                                    this.report = null;
                                }
                            } else {
                                this.report = null;
                            }
                            this.loading = false;
                        });
                }
            }
        }
    </script>
</div>