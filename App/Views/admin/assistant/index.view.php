<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-purple-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                </svg>
                AI Assistant
            </h1>
            <p class="text-gray-600 mt-1">Intelligent business insights powered by OpenAI</p>
        </div>
    </div>

    <!-- Analysis Tools Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- SWOT Analysis -->
        <a href="<?= url('admin/assistant/swot') ?>" class="group bg-linear-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-blue-200 hover:border-blue-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    🎯
                </div>
                <h3 class="text-xl font-bold text-gray-800">SWOT Analysis</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Identify Strengths, Weaknesses, Opportunities, and Threats in your business
            </p>
        </a>

        <!-- Revenue Analysis -->
        <a href="<?= url('admin/assistant/revenue') ?>" class="group bg-linear-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-green-200 hover:border-green-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    💰
                </div>
                <h3 class="text-xl font-bold text-gray-800">Revenue Analysis</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Analyze revenue trends, patterns, and growth opportunities
            </p>
        </a>

        <!-- Business Forecast -->
        <a href="<?= url('admin/assistant/forecast') ?>" class="group bg-linear-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-purple-200 hover:border-purple-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    📈
                </div>
                <h3 class="text-xl font-bold text-gray-800">Business Forecast</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Predict future trends and sales based on historical data
            </p>
        </a>

        <!-- Stock Analysis -->
        <a href="<?= url('admin/assistant/stock') ?>" class="group bg-linear-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-orange-200 hover:border-orange-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    📦
                </div>
                <h3 class="text-xl font-bold text-gray-800">Stock Analysis</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Inventory insights and restocking recommendations
            </p>
        </a>

        <!-- CSAT Analysis -->
        <a href="<?= url('admin/assistant/csat') ?>" class="group bg-linear-to-br from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-pink-200 hover:border-pink-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    ⭐
                </div>
                <h3 class="text-xl font-bold text-gray-800">CSAT Analysis</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Customer satisfaction sentiment from reviews and ratings
            </p>
        </a>

        <!-- Statistics -->
        <a href="<?= url('admin/assistant/statistics') ?>" class="group bg-linear-to-br from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 rounded-xl shadow-md hover:shadow-xl transition-all p-6 border-2 border-indigo-200 hover:border-indigo-400">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center text-white text-2xl mr-3 group-hover:scale-110 transition-transform">
                    📊
                </div>
                <h3 class="text-xl font-bold text-gray-800">Statistics</h3>
            </div>
            <p class="text-gray-700 text-sm">
                Comprehensive business statistics and key metrics
            </p>
        </a>
    </div>

    <!-- Advanced Tools -->
    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
            </svg>
            Advanced Tools
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="<?= url('admin/assistant/sandbox') ?>" class="group bg-white hover:bg-linear-to-r hover:from-purple-50 hover:to-pink-50 rounded-lg shadow hover:shadow-lg transition-all p-4 border border-gray-200 hover:border-purple-300 flex items-center gap-4">
                <div class="w-10 h-10 bg-linear-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white text-xl group-hover:scale-110 transition-transform">
                    🤖
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">AI Sandbox</h3>
                    <p class="text-sm text-gray-600">Custom prompts with transaction data</p>
                </div>
            </a>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200 flex items-center gap-4 opacity-60">
                <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center text-white text-xl">
                    🔮
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">More Coming Soon</h3>
                    <p class="text-sm text-gray-600">Additional AI tools in development</p>
                </div>
            </div>
        </div>
    </div>
</div>