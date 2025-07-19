<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-blue-900">Key Metrics (Last 30 Days)</h3>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Orders -->
        <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-100 hover:shadow-lg transition">
            <div class="bg-blue-100 text-blue-600 rounded-lg p-3 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2zm0 4h18v2H3v-2z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Orders</div>
                <div class="text-2xl font-bold text-blue-900">42</div>
            </div>
        </div>
        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-100 hover:shadow-lg transition">
            <div class="bg-green-100 text-green-600 rounded-lg p-3 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-green-500 font-medium uppercase tracking-wide">Revenue</div>
                <div class="text-2xl font-bold text-blue-900">MVR 18,500</div>
            </div>
        </div>
        <!-- Trend -->
        <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-100 hover:shadow-lg transition">
            <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-indigo-500 font-medium uppercase tracking-wide">Trend</div>
                <div class="text-2xl font-bold text-blue-900">+12%</div>
            </div>
        </div>
        <!-- CSAT -->
        <div class="bg-white rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-100 hover:shadow-lg transition">
            <div class="bg-yellow-100 text-yellow-600 rounded-lg p-3 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 15l4-4 4 4" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-yellow-500 font-medium uppercase tracking-wide">CSAT</div>
                <div class="text-2xl font-bold text-blue-900">4.7/5</div>
                <div class="text-xs text-gray-500 mt-1">Recommendation: <span class="font-semibold text-blue-700">92%</span></div>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-blue-900">Business Insights</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        <!-- Revenue & Orders Chart -->
        <div class="col-span-1 lg:col-span-2 bg-white rounded-xl shadow-md p-5 flex flex-col border border-blue-100 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2zm0 4h18v2H3v-2z" />
                    </svg>
                </div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Revenue & Orders Trend</div>
            </div>
            <div class="flex-1 flex items-center justify-center" style="height:220px;min-height:180px;max-height:220px;">
                <canvas id="revenueOrdersChart" class="w-full max-w-xl" style="height:200px!important;max-height:200px;min-height:200px;" height="200"></canvas>
            </div>
        </div>
        <!-- Quarterly Report -->
        <div class="col-span-1 h-full bg-white rounded-xl shadow-md p-5 flex flex-col border border-blue-100 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 15l4-4 4 4" />
                    </svg>
                </div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide"><?php echo date('Y') ?> Quarterly Report</div>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center mt-2" style="height:180px;min-height:140px;max-height:180px;">
                <canvas id="quarterlyReportChart" class="w-full max-w-xs" style="height:140px!important;max-height:140px;min-height:140px;" height="140"></canvas>
                <ul class="text-gray-700 text-xs mt-4 w-full flex justify-between px-2">
                    <li>Q1: <span class="font-semibold">MVR 5,200</span></li>
                    <li>Q2: <span class="font-semibold">MVR 6,800</span></li>
                    <li>Q3: <span class="font-semibold">MVR 4,500</span></li>
                    <li>Q4: <span class="font-semibold">MVR 2,000</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 py-6">
        <!-- Top Products -->
        <div class="col-span-1 bg-white rounded-xl shadow-md p-5 flex flex-col border border-blue-100 hover:shadow-lg transition">
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
        <div class="col-span-1 bg-white rounded-xl shadow-md p-5 flex flex-col border border-blue-100 hover:shadow-lg transition">
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
        <div class="col-span-1 bg-white rounded-xl shadow-md p-5 flex flex-col border border-blue-100 hover:shadow-lg transition">
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="col-span-1 md:col-span-3 bg-white rounded-xl shadow-md p-6 border border-blue-100">
            <h4 class="font-semibold mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 20l9-5-9-5-9 5 9 5z" />
                    <path d="M12 12V4" />
                </svg>
                Recent Reviews
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="flex flex-col gap-2 p-4 rounded-lg bg-blue-50 border border-blue-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-semibold text-blue-900">Fathimath S.</span>
                            <span class="block text-xs text-blue-400">Architectural Model</span>
                        </div>
                        <!-- Product Quality -->
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex items-center gap-1">
                                <span class="text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                    </svg>
                                </span><span>5</span>
                            </div>
                        </div>
                        <!-- Pricing -->
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex items-center gap-1">
                                <span class="text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                </span><span>5</span>
                            </div>
                        </div>
                        <!-- Communication -->
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex items-center gap-1">
                                <span class="text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                    </svg>
                                </span><span>5</span>
                            </div>
                        </div>
                        <!-- Packaging -->
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex items-center gap-1">
                                <span class="text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                </span><span>5</span>
                            </div>
                        </div>
                        <!-- Delivery -->
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex items-center gap-1">
                                <span class="text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>
                                </span><span>5</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-blue-700 italic text-xs mt-2">"Impressed with the service!"</div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue & Orders Trend Chart
    const ctx1 = document.getElementById('revenueOrdersChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 5', 'Day 10', 'Day 15', 'Day 20', 'Day 25', 'Day 30'],
            datasets: [{
                    label: 'Revenue',
                    data: [1200, 1800, 1500, 2200, 2000, 2500, 2300],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                },
                {
                    label: 'Orders',
                    data: [5, 8, 7, 10, 9, 12, 11],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: false,
                    pointRadius: 3,
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Quarterly Report Bar Chart
    const ctx2 = document.getElementById('quarterlyReportChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Revenue',
                data: [5200, 6800, 4500, 2000],
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e42',
                    '#ef4444'
                ],
                borderRadius: 8,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>