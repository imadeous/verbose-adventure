<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-gray-900">Key Metrics (Last 30 Days)</h3>
    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2zm0 4h18v2H3v-2z" />
                </svg>
            </div>
            <div>
                <dt class="truncate text-sm font-medium text-gray-500">Orders</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">42</dd>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 flex items-center gap-4">
            <div class="bg-green-100 text-green-600 rounded-full p-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                </svg>
            </div>
            <div>
                <dt class="truncate text-sm font-medium text-gray-500">Revenue</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">MVR 18,500</dd>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 flex items-center gap-4">
            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3" />
                </svg>
            </div>
            <div>
                <dt class="truncate text-sm font-medium text-gray-500">Avg. Revenue</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">MVR 440</dd>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 flex items-center gap-4">
            <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 15l4-4 4 4" />
                </svg>
            </div>
            <div>
                <dt class="truncate text-sm font-medium text-gray-500">CSAT</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">4.7/5</dd>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-gray-900">Business Insights</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        <!-- Revenue & Orders Chart -->
        <div class="col-span-1 lg:col-span-2 p-4 bg-white text-sm shadow-lg rounded-lg flex flex-col justify-between">
            <h4 class="font-semibold mb-2">Revenue & Orders Trend</h4>
            <div class="flex-1 flex items-center justify-center">
                <span class="text-gray-400">[Line Chart Placeholder]</span>
            </div>
        </div>
        <!-- Quarterly Report -->
        <div class="col-span-1 h-full px-6 py-4 text-sm shadow-lg rounded-lg bg-white flex flex-col">
            <h4 class="font-semibold mb-2"><?php echo date('Y') ?> Quarterly Report</h4>
            <ul class="text-gray-700">
                <li>Q1 Revenue: <span class="font-semibold">MVR 5,200.00</span></li>
                <li>Q2 Revenue: <span class="font-semibold">MVR 6,800.00</span></li>
                <li>Q3 Revenue: <span class="font-semibold">MVR 4,500.00</span></li>
                <li>Q4 Revenue: <span class="font-semibold">MVR 2,000.00</span></li>
            </ul>
            <div class="flex-1 flex items-center justify-center mt-4">
                <span class="text-gray-400">[Bar Chart Placeholder]</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Top Products -->
    <div class="col-span-1 bg-white p-6 rounded-lg shadow flex flex-col">
        <h4 class="font-semibold mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>Top Products</h4>
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-blue-400"></span>
                <span class="font-medium">Custom Keychains</span>
                <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">12 orders</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-green-400"></span>
                <span class="font-medium">Architectural Models</span>
                <span class="ml-auto bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">8 orders</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-yellow-400"></span>
                <span class="font-medium">Miniature Figures</span>
                <span class="ml-auto bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">7 orders</span>
            </div>
        </div>
    </div>
    <!-- Promo Code Usage -->
    <div class="col-span-1 bg-white p-6 rounded-lg shadow flex flex-col">
        <h4 class="font-semibold mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 9V7a5 5 0 0 0-10 0v2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2z" />
            </svg>Promo Code Usage</h4>
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-2">
                <span class="font-mono bg-pink-100 text-pink-700 px-2 py-1 rounded">WELCOME10</span>
                <div class="w-32 bg-pink-200 rounded-full h-2 mx-2">
                    <div class="bg-pink-500 h-2 rounded-full" style="width: 70%"></div>
                </div>
                <span class="text-xs text-pink-700">6 uses</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-mono bg-pink-100 text-pink-700 px-2 py-1 rounded">SUMMER25</span>
                <div class="w-32 bg-pink-200 rounded-full h-2 mx-2">
                    <div class="bg-pink-400 h-2 rounded-full" style="width: 35%"></div>
                </div>
                <span class="text-xs text-pink-700">3 uses</span>
            </div>
        </div>
    </div>
    <!-- Expense Breakdown -->
    <div class="col-span-1 bg-white p-6 rounded-lg shadow flex flex-col">
        <h4 class="font-semibold mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
            </svg>Expense Breakdown</h4>
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-red-400"></span>
                <span class="font-medium">Materials</span>
                <div class="w-24 bg-red-200 rounded-full h-2 mx-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 60%"></div>
                </div>
                <span class="ml-auto font-semibold text-red-700">MVR 2,100</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-orange-400"></span>
                <span class="font-medium">Maintenance</span>
                <div class="w-24 bg-orange-200 rounded-full h-2 mx-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: 25%"></div>
                </div>
                <span class="ml-auto font-semibold text-orange-700">MVR 800</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-full bg-yellow-400"></span>
                <span class="font-medium">Marketing</span>
                <div class="w-24 bg-yellow-200 rounded-full h-2 mx-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 15%"></div>
                </div>
                <span class="ml-auto font-semibold text-yellow-700">MVR 500</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h4 class="font-semibold mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 20l9-5-9-5-9 5 9 5z" />
            <path d="M12 12V4" />
        </svg>Recent Reviews</h4>
    <div class="flex flex-col gap-4">
        <div class="flex items-center gap-4 p-3 rounded-lg bg-gray-50">
            <div class="flex flex-col items-center justify-center">
                <span class="font-semibold text-gray-800">Aishath L.</span>
                <span class="text-xs text-gray-400">Custom Keychain</span>
            </div>
            <div class="flex items-center gap-1 ml-6">
                <span class="text-yellow-400">★</span><span>5</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-green-400">💲</span><span>4</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-blue-400">🚚</span><span>5</span>
            </div>
            <div class="ml-auto text-gray-600 italic text-xs">"Great quality and fast delivery!"</div>
        </div>
        <div class="flex items-center gap-4 p-3 rounded-lg bg-gray-50">
            <div class="flex flex-col items-center justify-center">
                <span class="font-semibold text-gray-800">Mohamed R.</span>
                <span class="text-xs text-gray-400">Miniature Figure</span>
            </div>
            <div class="flex items-center gap-1 ml-6">
                <span class="text-yellow-400">★</span><span>4</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-green-400">💲</span><span>5</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-blue-400">🚚</span><span>4</span>
            </div>
            <div class="ml-auto text-gray-600 italic text-xs">"Very detailed and well-priced."</div>
        </div>
        <div class="flex items-center gap-4 p-3 rounded-lg bg-gray-50">
            <div class="flex flex-col items-center justify-center">
                <span class="font-semibold text-gray-800">Fathimath S.</span>
                <span class="text-xs text-gray-400">Architectural Model</span>
            </div>
            <div class="flex items-center gap-1 ml-6">
                <span class="text-yellow-400">★</span><span>5</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-green-400">💲</span><span>5</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="text-blue-400">🚚</span><span>5</span>
            </div>
            <div class="ml-auto text-gray-600 italic text-xs">"Impressed with the service!"</div>
        </div>
    </div>
</div>