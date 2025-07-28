<div class="max-full mx-auto" x-data="reportApp()" x-init="init()">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-900">Reports</h1>
                <!-- Sidebar nav for pre-built reports -->
                <nav class="md:w-64 w-full mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-blue-800 mb-2">Pre-built Reports</h2>
                    <select class="w-full border rounded-lg px-3 py-2 text-blue-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300" @change="setPrebuilt($event.target.value)">
                        <option value="" disabled selected>Select a report...</option>
                        <option value="daily_income">Daily Income</option>
                        <option value="daily_expense">Daily Expenses</option>
                        <option value="monthly_income">Monthly Income</option>
                        <option value="monthly_expense">Monthly Expenses</option>
                        <option value="quarterly_income">Quarterly Income</option>
                        <option value="quarterly_expense">Quarterly Expenses</option>
                        <option value="yearly_income">Yearly Income</option>
                        <option value="yearly_expense">Yearly Expenses</option>
                        <option value="all_transactions">All Transactions</option>
                    </select>
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
                            <label><input type="checkbox" checked x-model="aggregate_sum"> Sum</label>
                            <label><input type="checkbox" x-model="aggregate_avg"> Average</label>
                            <label><input type="checkbox" x-model="aggregate_min"> Min</label>
                            <label><input type="checkbox" x-model="aggregate_max"> Max</label>
                            <label><input type="checkbox" x-model="aggregate_count"> Count</label>
                        </div>
                    </div>
                </form>
                <template x-if="loading">
                    <div class="text-blue-400">Loading report...</div>
                </template>
                <h2 class="text-xl font-semibold text-blue-900 mb-4" x-text="`Transactions Report: ${period_start} to ${period_end}`"></h2>
                <template x-if="!loading && report && report.data && report.data.length">
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full bg-white rounded-xl text-sm">
                            <thead>
                                <tr>
                                    <template x-for="(label, key) in columns" :key="key">
                                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200" x-text="label"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(row, rowIndex) in report.data" :key="rowIndex">
                                    <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                                        <template x-for="(label, key) in columns" :key="key">
                                            <td class="px-4 py-2 whitespace-nowrap" :class="['Total','Average','Min','Max'].includes(key) && Number(row[key]) < 0 ? 'text-red-500' : 'text-blue-900'">
                                                <template x-if="['Total','Average','Min','Max','Count'].includes(key)">
                                                    <span x-text="Number(row[key] ?? 0).toFixed(2)"></span>
                                                </template>
                                                <template x-if="!['Total','Average','Min','Max','Count'].includes(key)">
                                                    <span x-text="row[key] ?? '-'"></span>
                                                </template>
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template x-if="!loading && (!report || !report.data || !report.data.length)">
                    <p class="text-blue-400">No report data available for this period.</p>
                </template>
            </div>
        </div>
    </div>
    <script>
        function reportApp() {
            return {
                // ...existing code...
                setPrebuilt(type) {

                    // Pre-built report presets (transactions table only)
                    const today = new Date();
                    const yyyy = today.getFullYear();
                    const mm = String(today.getMonth() + 1).padStart(2, '0');
                    const firstDay = `${yyyy}-01-01`;
                    const firstDayofMonth = new Date(yyyy, today.getMonth(), 1).toISOString().slice(0, 10);
                    const lastDay = new Date(yyyy, today.getMonth() + 1, 0).toISOString().slice(0, 10);
                    if (type === 'daily_income') {
                        // Today only, daily grouping
                        const todayStr = today.toISOString().slice(0, 10);
                        this.period_start = firstDayofMonth;
                        this.period_end = todayStr;
                        this.grouping = 'daily';
                        this.type = 'income';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'daily_expense') {
                        const todayStr = today.toISOString().slice(0, 10);
                        this.period_start = todayStr;
                        this.period_end = todayStr;
                        this.grouping = 'daily';
                        this.type = 'expense';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'monthly_income') {
                        this.period_start = firstDay;
                        this.period_end = lastDay;
                        this.grouping = 'monthly';
                        this.type = 'income';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'monthly_expense') {
                        this.period_start = firstDay;
                        this.period_end = lastDay;
                        this.grouping = 'monthly';
                        this.type = 'expense';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'quarterly_income') {
                        this.period_start = `${yyyy}-01-01`;
                        this.period_end = `${yyyy}-12-31`;
                        this.grouping = 'quarterly';
                        this.type = 'income';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'quarterly_expense') {
                        this.period_start = `${yyyy}-01-01`;
                        this.period_end = `${yyyy}-12-31`;
                        this.grouping = 'quarterly';
                        this.type = 'expense';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'yearly_income') {
                        this.period_start = `2020-01-01`;
                        this.period_end = `${yyyy}-12-31`;
                        this.grouping = 'yearly';
                        this.type = 'income';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'yearly_expense') {
                        this.period_start = `2020-01-01`;
                        this.period_end = `${yyyy}-12-31`;
                        this.grouping = 'yearly';
                        this.type = 'expense';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = false;
                        this.aggregate_max = false;
                        this.aggregate_count = true;
                    } else if (type === 'all_transactions') {
                        this.period_start = `${yyyy}-01-01`;
                        this.period_end = `${yyyy}-12-31`;
                        this.grouping = 'monthly';
                        this.type = 'all';
                        this.aggregate_sum = true;
                        this.aggregate_avg = true;
                        this.aggregate_min = true;
                        this.aggregate_max = true;
                        this.aggregate_count = true;
                    }
                    this.fetchReport();
                },
                period_start: '<?= htmlspecialchars($_GET['period_start'] ?? date('Y-01-01')) ?>',
                period_end: '<?= htmlspecialchars($_GET['period_end'] ?? date('Y-12-31')) ?>',
                grouping: '<?= htmlspecialchars($_GET['grouping'] ?? 'monthly') ?>',
                type: '<?= htmlspecialchars($_GET['type'] ?? 'income') ?>',
                aggregate_sum: <?= !empty($_GET['aggregate_sum']) ? 'true' : 'true' ?>,
                aggregate_avg: <?= !empty($_GET['aggregate_avg']) ? 'true' : 'false' ?>,
                aggregate_min: <?= !empty($_GET['aggregate_min']) ? 'true' : 'false' ?>,
                aggregate_max: <?= !empty($_GET['aggregate_max']) ? 'true' : 'false' ?>,
                aggregate_count: <?= !empty($_GET['aggregate_count']) ? 'true' : 'false' ?>,
                groupings: {
                    daily: 'Daily',
                    weekly: 'Weekly',
                    monthly: 'Monthly',
                    quarterly: 'Quarterly',
                    yearly: 'Yearly'
                },
                report: <?= json_encode($report) ?>,
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
                        aggregate_count: this.aggregate_count ? '1' : '',
                        ajax: '1' // Add a flag to request JSON only
                    });
                    fetch(window.location.pathname + '?' + params.toString())
                        .then(r => r.json())
                        .then(data => {
                            this.report = data;
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
                                    } else if (key === 'Count') {
                                        this.columns[key] = 'Transaction Count';
                                    } else {
                                        this.columns[key] = key.charAt(0).toUpperCase() + key.slice(1);
                                    }
                                }
                            }
                            this.loading = false;
                        });
                }
            }
        }
    </script>
</div>