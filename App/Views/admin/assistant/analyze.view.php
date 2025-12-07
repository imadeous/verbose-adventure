<div class="max-w-4xl mx-auto" x-data="{ analysisTypes: [] }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
                Business Analysis
            </h1>
            <p class="text-gray-600 mt-1">Generate AI-powered insights for your business</p>
        </div>
    </div>

    <form method="POST" action="<?= url('admin/assistant/analyze/generate') ?>" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Date Range Selection -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                Select Analysis Period
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                    <input
                        type="date"
                        name="start_date"
                        required
                        value="<?= date('Y-m-01') ?>"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                    <input
                        type="date"
                        name="end_date"
                        required
                        value="<?= date('Y-m-d') ?>"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Quick Date Presets -->
            <div class="flex flex-wrap gap-2 mt-4">
                <button type="button" @click="setDateRange('today')" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full border border-gray-300 transition">Today</button>
                <button type="button" @click="setDateRange('week')" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full border border-gray-300 transition">This Week</button>
                <button type="button" @click="setDateRange('month')" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full border border-gray-300 transition">This Month</button>
                <button type="button" @click="setDateRange('quarter')" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full border border-gray-300 transition">This Quarter</button>
                <button type="button" @click="setDateRange('year')" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full border border-gray-300 transition">This Year</button>
            </div>
        </div>

        <!-- Analysis Type Selection -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Select Analysis Types
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Revenue Analysis -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('revenue') ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'">
                    <input type="checkbox" name="analysis_types[]" value="revenue"
                        class="mt-1 mr-3 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Revenue Analysis</div>
                        <div class="text-sm text-gray-600">Analyze revenue trends, patterns, and financial health</div>
                    </div>
                </label>

                <!-- SWOT Analysis -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('swot') ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                    <input type="checkbox" name="analysis_types[]" value="swot"
                        class="mt-1 mr-3 h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">SWOT Analysis</div>
                        <div class="text-sm text-gray-600">Identify Strengths, Weaknesses, Opportunities, Threats</div>
                    </div>
                </label>

                <!-- Stock Analysis -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('stock') ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300'">
                    <input type="checkbox" name="analysis_types[]" value="stock"
                        class="mt-1 mr-3 h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Stock Analysis</div>
                        <div class="text-sm text-gray-600">Evaluate inventory levels and stock management</div>
                    </div>
                </label>

                <!-- Forecasts -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('forecast') ? 'border-amber-500 bg-amber-50' : 'border-gray-200 hover:border-amber-300'">
                    <input type="checkbox" name="analysis_types[]" value="forecast"
                        class="mt-1 mr-3 h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Forecasts</div>
                        <div class="text-sm text-gray-600">Revenue and sales projections for next period</div>
                    </div>
                </label>

                <!-- Performance Comparison -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('comparison') ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300'">
                    <input type="checkbox" name="analysis_types[]" value="comparison"
                        class="mt-1 mr-3 h-5 w-5 text-pink-600 focus:ring-pink-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Performance Comparison</div>
                        <div class="text-sm text-gray-600">Compare products and categories performance</div>
                    </div>
                </label>

                <!-- Comprehensive Statistics -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('statistics') ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300'">
                    <input type="checkbox" name="analysis_types[]" value="statistics"
                        class="mt-1 mr-3 h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Comprehensive Statistics</div>
                        <div class="text-sm text-gray-600">Deep dive into all available metrics</div>
                    </div>
                </label>

                <!-- Category Performance -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('categories') ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:border-teal-300'">
                    <input type="checkbox" name="analysis_types[]" value="categories"
                        class="mt-1 mr-3 h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Category Performance</div>
                        <div class="text-sm text-gray-600">Analyze performance across product categories</div>
                    </div>
                </label>

                <!-- Product Performance -->
                <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer transition"
                    :class="analysisTypes.includes('products') ? 'border-cyan-500 bg-cyan-50' : 'border-gray-200 hover:border-cyan-300'">
                    <input type="checkbox" name="analysis_types[]" value="products"
                        class="mt-1 mr-3 h-5 w-5 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded"
                        x-model="analysisTypes">
                    <div>
                        <div class="font-semibold text-gray-900">Product Performance</div>
                        <div class="text-sm text-gray-600">Identify top and underperforming products</div>
                    </div>
                </label>
            </div>

            <!-- Quick Select Buttons -->
            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-200">
                <button type="button" @click="selectAllAnalysis()" class="text-sm px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-semibold transition">
                    Select All
                </button>
                <button type="button" @click="analysisTypes = []" class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition">
                    Clear All
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between items-center">
            <a href="<?= url('admin/assistant') ?>" class="text-gray-600 hover:text-gray-800 font-semibold">
                ← Back to Assistant
            </a>
            <button type="submit"
                :disabled="analysisTypes.length === 0"
                :class="analysisTypes.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                class="px-8 py-3 text-white rounded-lg font-bold shadow-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                </svg>
                Generate Analysis
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('analysisForm', () => ({
            setDateRange(range) {
                const today = new Date();
                const startInput = document.querySelector('input[name="start_date"]');
                const endInput = document.querySelector('input[name="end_date"]');

                let startDate = new Date();
                let endDate = new Date();

                switch (range) {
                    case 'today':
                        startDate = today;
                        endDate = today;
                        break;
                    case 'week':
                        startDate = new Date(today.setDate(today.getDate() - today.getDay()));
                        endDate = new Date();
                        break;
                    case 'month':
                        startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                        endDate = new Date();
                        break;
                    case 'quarter':
                        const quarter = Math.floor(today.getMonth() / 3);
                        startDate = new Date(today.getFullYear(), quarter * 3, 1);
                        endDate = new Date();
                        break;
                    case 'year':
                        startDate = new Date(today.getFullYear(), 0, 1);
                        endDate = new Date();
                        break;
                }

                startInput.value = startDate.toISOString().split('T')[0];
                endInput.value = endDate.toISOString().split('T')[0];
            },

            selectAllAnalysis() {
                this.analysisTypes = ['revenue', 'swot', 'stock', 'forecast', 'comparison', 'statistics', 'categories', 'products'];
            }
        }));
    });
</script>