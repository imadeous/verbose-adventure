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
            <div
                x-data="{
                    reviews: [
                        {
                            name: 'Fathimath S.',
                            product: 'Architectural Model',
                            ratings: { quality: 5, pricing: 5, communication: 5, packaging: 5, delivery: 5 },
                            comment: 'Impressed with the service!'
                        },
                        {
                            name: 'Ahmed R.',
                            product: 'Custom Keychains',
                            ratings: { quality: 4, pricing: 5, communication: 4, packaging: 5, delivery: 5 },
                            comment: 'Great quality and fast delivery.'
                        },
                        {
                            name: 'Zuleikha M.',
                            product: 'Miniature Figures',
                            ratings: { quality: 5, pricing: 4, communication: 5, packaging: 4, delivery: 5 },
                            comment: 'Very detailed work, will order again.'
                        },
                        {
                            name: 'Ibrahim A.',
                            product: 'Architectural Model',
                            ratings: { quality: 5, pricing: 5, communication: 5, packaging: 5, delivery: 4 },
                            comment: 'Packaging could be improved, but overall excellent.'
                        },
                        {
                            name: 'Aishath L.',
                            product: 'Custom Keychains',
                            ratings: { quality: 5, pricing: 5, communication: 5, packaging: 5, delivery: 5 },
                            comment: 'Perfect experience from start to finish!'
                        }
                    ]
                }">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="(review, idx) in reviews" :key="idx">
                        <div class="flex flex-col gap-3 p-5 rounded-xl bg-blue-50 border border-blue-100 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <div>
                                    <span class="font-semibold text-blue-900" x-text="review.name"></span>
                                    <span class="block text-xs text-blue-400" x-text="review.product"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-700">Quality</span>
                                    <span class="flex items-center gap-1">
                                        <template x-for="n in review.ratings.quality">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <polygon points="10 1.5 12.59 7.36 18.9 7.97 14 12.14 15.18 18.36 10 15.27 4.82 18.36 6 12.14 1.1 7.97 7.41 7.36 10 1.5" />
                                            </svg>
                                        </template>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-700">Pricing</span>
                                    <span class="flex items-center gap-1">
                                        <template x-for="n in review.ratings.pricing">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <polygon points="10 1.5 12.59 7.36 18.9 7.97 14 12.14 15.18 18.36 10 15.27 4.82 18.36 6 12.14 1.1 7.97 7.41 7.36 10 1.5" />
                                            </svg>
                                        </template>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-700">Communication</span>
                                    <span class="flex items-center gap-1">
                                        <template x-for="n in review.ratings.communication">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <polygon points="10 1.5 12.59 7.36 18.9 7.97 14 12.14 15.18 18.36 10 15.27 4.82 18.36 6 12.14 1.1 7.97 7.41 7.36 10 1.5" />
                                            </svg>
                                        </template>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-700">Packaging</span>
                                    <span class="flex items-center gap-1">
                                        <template x-for="n in review.ratings.packaging">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <polygon points="10 1.5 12.59 7.36 18.9 7.97 14 12.14 15.18 18.36 10 15.27 4.82 18.36 6 12.14 1.1 7.97 7.41 7.36 10 1.5" />
                                            </svg>
                                        </template>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-700">Delivery</span>
                                    <span class="flex items-center gap-1">
                                        <template x-for="n in review.ratings.delivery">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <polygon points="10 1.5 12.59 7.36 18.9 7.97 14 12.14 15.18 18.36 10 15.27 4.82 18.36 6 12.14 1.1 7.97 7.41 7.36 10 1.5" />
                                            </svg>
                                        </template>
                                    </span>
                                </div>
                            </div>
                            <div class="text-blue-700 italic mt-3" x-text="`\" ${review.comment}\"`"></div>
                        </div>
                    </template>
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