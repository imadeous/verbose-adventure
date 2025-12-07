<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">AI Sandbox</h2>
            <p class="text-gray-600">
                Select a date range to retrieve transaction data, then write a custom prompt to ask the AI anything about your data.
            </p>
        </div>

        <form method="POST" action="<?= url('admin/assistant/sandbox/execute') ?>" class="space-y-6" x-data="{
            startDate: '',
            endDate: '',
            customPrompt: '',
            setDateRange(days) {
                const end = new Date();
                const start = new Date();
                start.setDate(start.getDate() - days);
                
                this.endDate = end.toISOString().split('T')[0];
                this.startDate = start.toISOString().split('T')[0];
            }
        }">
            <?= csrf_field() ?>

            <!-- Date Range Selection -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Select Date Range</h3>

                <!-- Quick Presets -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quick Presets</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="setDateRange(7)" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded text-sm transition">
                            Last 7 Days
                        </button>
                        <button type="button" @click="setDateRange(30)" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded text-sm transition">
                            Last 30 Days
                        </button>
                        <button type="button" @click="setDateRange(90)" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded text-sm transition">
                            Last 90 Days
                        </button>
                        <button type="button" @click="setDateRange(365)" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded text-sm transition">
                            Last Year
                        </button>
                    </div>
                </div>

                <!-- Custom Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                        <input type="date"
                            id="start_date"
                            name="start_date"
                            x-model="startDate"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                        <input type="date"
                            id="end_date"
                            name="end_date"
                            x-model="endDate"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Custom Prompt -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Custom AI Prompt</h3>
                <p class="text-sm text-gray-600 mb-3">
                    Write your instructions for the AI. Be specific about what insights, analysis, or actions you want.
                </p>

                <label for="custom_prompt" class="block text-sm font-medium text-gray-700 mb-1">Your Prompt *</label>
                <textarea id="custom_prompt"
                    name="custom_prompt"
                    x-model="customPrompt"
                    required
                    rows="8"
                    placeholder="Example: Analyze sales trends and identify the top 3 best-selling products. Provide recommendations for inventory management."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 font-mono text-sm"></textarea>

                <p class="text-xs text-gray-500 mt-2">
                    The AI will receive all transaction data from your selected date range along with your prompt.
                </p>
            </div>

            <!-- Example Prompts -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <span class="mr-2">💡</span>Example Prompts
                </h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="text-purple-600 mr-2">•</span>
                        <span>"Analyze revenue trends and predict next month's sales based on patterns."</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 mr-2">•</span>
                        <span>"Identify seasonal patterns in product sales and recommend optimal inventory levels."</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 mr-2">•</span>
                        <span>"Compare category performance and suggest which categories to focus marketing efforts on."</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 mr-2">•</span>
                        <span>"Find unusual transaction patterns or anomalies that might indicate issues."</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-purple-600 mr-2">•</span>
                        <span>"Create a detailed customer behavior analysis based on transaction timing and amounts."</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-4 border-t">
                <a href="<?= url('admin/assistant') ?>" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-md transition shadow-md">
                    <span class="mr-2">🤖</span>
                    Run AI Analysis
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <h4 class="font-semibold text-gray-800 mb-2">💡 Tips for Better Results</h4>
        <ul class="space-y-1 text-sm text-gray-700">
            <li class="flex items-start">
                <span class="text-yellow-600 mr-2">→</span>
                <span>Be specific about what you want to learn or what actions you need</span>
            </li>
            <li class="flex items-start">
                <span class="text-yellow-600 mr-2">→</span>
                <span>Ask for specific metrics, trends, or comparisons</span>
            </li>
            <li class="flex items-start">
                <span class="text-yellow-600 mr-2">→</span>
                <span>Request actionable recommendations when appropriate</span>
            </li>
            <li class="flex items-start">
                <span class="text-yellow-600 mr-2">→</span>
                <span>Choose date ranges that match your analysis goals (daily, weekly, monthly, seasonal)</span>
            </li>
        </ul>
    </div>
</div>