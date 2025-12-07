<div class="max-w-5xl mx-auto" x-data="{ showRawData: false }">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Analysis Report Generated
        </h1>
        <p class="text-gray-600 mt-1">Period: <?= e($startDate) ?> to <?= e($endDate) ?></p>
        <div class="flex flex-wrap gap-2 mt-3">
            <?php foreach ($analysisTypes as $type): ?>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                    <?= ucfirst($type) ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- AI Analysis Result -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-6">
        <div class="prose max-w-none">
            <?php
            // Convert markdown to HTML (basic conversion)
            $html = $analysis;

            // Headers
            $html = preg_replace('/^### (.+)$/m', '<h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">$1</h3>', $html);
            $html = preg_replace('/^## (.+)$/m', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">$1</h2>', $html);
            $html = preg_replace('/^# (.+)$/m', '<h1 class="text-3xl font-extrabold text-gray-900 mt-8 mb-4">$1</h1>', $html);

            // Bold and italic
            $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-bold text-gray-900">$1</strong>', $html);
            $html = preg_replace('/\*(.+?)\*/s', '<em class="italic">$1</em>', $html);

            // Lists
            $html = preg_replace('/^- (.+)$/m', '<li class="ml-6 mb-2">$1</li>', $html);
            $html = preg_replace('/^(\d+)\. (.+)$/m', '<li class="ml-6 mb-2">$2</li>', $html);

            // Wrap consecutive list items
            $html = preg_replace('/(<li.*<\/li>\n)+/', '<ul class="list-disc mb-4">$0</ul>', $html);

            // Paragraphs
            $html = preg_replace('/^(?!<[hul]|$)(.+)$/m', '<p class="mb-4 text-gray-700 leading-relaxed">$1</p>', $html);

            // Code blocks
            $html = preg_replace('/```(.+?)```/s', '<pre class="bg-gray-100 p-4 rounded-lg mb-4 overflow-x-auto"><code>$1</code></pre>', $html);

            echo $html;
            ?>
        </div>
    </div>

    <!-- Raw Data Toggle -->
    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 mb-6">
        <button @click="showRawData = !showRawData" class="w-full flex items-center justify-between text-left">
            <span class="font-semibold text-gray-700">View Raw Business Data</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-5 h-5 transition-transform" :class="showRawData ? 'rotate-180' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

        <div x-show="showRawData" x-collapse class="mt-4 space-y-4">
            <?php if (isset($businessData['revenue'])): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Revenue Data</h4>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Total Revenue:</span>
                            <span class="font-bold text-green-600">$<?= number_format($businessData['revenue']['total'], 2) ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total Orders:</span>
                            <span class="font-bold"><?= $businessData['revenue']['total_orders'] ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Avg Order Value:</span>
                            <span class="font-bold">$<?= number_format($businessData['revenue']['average_order_value'], 2) ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($businessData['stock'])): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Stock Data</h4>
                    <div class="grid grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Total Products:</span>
                            <span class="font-bold"><?= $businessData['stock']['total_products'] ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Total Units:</span>
                            <span class="font-bold"><?= $businessData['stock']['total_stock_units'] ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Low Stock:</span>
                            <span class="font-bold text-amber-600"><?= count($businessData['stock']['low_stock_items']) ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Out of Stock:</span>
                            <span class="font-bold text-red-600"><?= count($businessData['stock']['out_of_stock_items']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($businessData['categories']) && !empty($businessData['categories'])): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Top Categories</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left">Category</th>
                                    <th class="px-3 py-2 text-right">Revenue</th>
                                    <th class="px-3 py-2 text-right">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($businessData['categories'], 0, 5) as $cat): ?>
                                    <tr class="border-t">
                                        <td class="px-3 py-2"><?= e($cat['name']) ?></td>
                                        <td class="px-3 py-2 text-right font-semibold text-green-600">$<?= number_format($cat['revenue'], 2) ?></td>
                                        <td class="px-3 py-2 text-right"><?= $cat['orders'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($businessData['products']) && !empty($businessData['products'])): ?>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-2">Top Products</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left">Product</th>
                                    <th class="px-3 py-2 text-right">Revenue</th>
                                    <th class="px-3 py-2 text-right">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($businessData['products'], 0, 10) as $prod): ?>
                                    <tr class="border-t">
                                        <td class="px-3 py-2"><?= e($prod['name']) ?></td>
                                        <td class="px-3 py-2 text-right font-semibold text-green-600">$<?= number_format($prod['revenue'], 2) ?></td>
                                        <td class="px-3 py-2 text-right"><?= $prod['orders'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <a href="<?= url('admin/assistant/analyze') ?>" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
            ← New Analysis
        </a>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                Print Report
            </button>
        </div>
    </div>
</div>

<style>
    @media print {

        .no-print,
        nav,
        header,
        footer,
        button {
            display: none !important;
        }
    }
</style>