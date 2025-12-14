<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">AI Sandbox Result</h2>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><strong>Date Range:</strong> <?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?></p>
                    <p><strong>Transactions Analyzed:</strong> <?= $transactionCount ?></p>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>
                <a href="<?= url('admin/assistant/sandbox') ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Analysis
                </a>
            </div>
        </div>

        <!-- User Prompt Display -->
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-800 mb-2">Your Prompt:</h3>
            <p class="text-gray-700 whitespace-pre-wrap"><?= htmlspecialchars($customPrompt) ?></p>
        </div>
    </div>

    <!-- AI Response Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="text-2xl">🤖</span>
            AI Analysis
        </h3>
        <div class="prose max-w-none">
            <?php
            // Simple markdown to HTML conversion
            $html = htmlspecialchars($aiResponse);

            // Headers
            $html = preg_replace('/^### (.+)$/m', '<h3 class="text-lg font-bold mt-4 mb-2">$1</h3>', $html);
            $html = preg_replace('/^## (.+)$/m', '<h2 class="text-xl font-bold mt-6 mb-3">$1</h2>', $html);
            $html = preg_replace('/^# (.+)$/m', '<h1 class="text-2xl font-bold mt-8 mb-4">$1</h1>', $html);

            // Bold and italic
            $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);
            $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);

            // Lists
            $html = preg_replace('/^\- (.+)$/m', '<li class="ml-4">$1</li>', $html);
            $html = preg_replace('/^(\d+)\. (.+)$/m', '<li class="ml-4">$2</li>', $html);

            // Wrap consecutive list items
            $html = preg_replace('/(<li.*<\/li>\n)+/s', '<ul class="list-disc my-2">$0</ul>', $html);

            // Paragraphs
            $html = preg_replace('/\n\n/', '</p><p class="mb-2">', $html);
            $html = '<p class="mb-2">' . $html . '</p>';

            // Code blocks
            $html = preg_replace('/```(.+?)```/s', '<pre class="bg-gray-100 p-3 rounded my-2 overflow-x-auto"><code>$1</code></pre>', $html);
            $html = preg_replace('/`(.+?)`/', '<code class="bg-gray-100 px-1 rounded">$1</code>', $html);

            // Line breaks
            $html = nl2br($html);

            echo $html;
            ?>
        </div>
    </div>

    <!-- Transaction Data Section (Collapsible) -->
    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ showData: false }">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Transaction Data</h3>
            <button @click="showData = !showData" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-sm transition">
                <span x-show="!showData">Show Data</span>
                <span x-show="showData">Hide Data</span>
            </button>
        </div>

        <div x-show="showData" x-collapse>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($transactions as $transaction):
                            $date = is_array($transaction) ? $transaction['date'] : $transaction->date;
                            $type = is_array($transaction) ? ($transaction['type'] ?? 'N/A') : ($transaction->type ?? 'N/A');
                            $categoryId = is_array($transaction) ? ($transaction['category_id'] ?? null) : ($transaction->category_id ?? null);
                            $productId = is_array($transaction) ? ($transaction['product_id'] ?? null) : ($transaction->product_id ?? null);
                            $amount = is_array($transaction) ? ($transaction['amount'] ?? 0) : ($transaction->amount ?? 0);
                            $notes = is_array($transaction) ? ($transaction['notes'] ?? '') : ($transaction->notes ?? '');

                            // Get category name
                            $categoryName = 'N/A';
                            if ($categoryId) {
                                $category = \App\Models\Category::find($categoryId);
                                if ($category) {
                                    $categoryName = is_array($category) ? $category['name'] : $category->name;
                                }
                            }

                            // Get product name
                            $productName = 'N/A';
                            if ($productId) {
                                $product = \App\Models\Product::find($productId);
                                if ($product) {
                                    $productName = is_array($product) ? $product['name'] : $product->name;
                                }
                            }
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($date) ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full <?= $type === 'sale' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= htmlspecialchars(ucfirst($type)) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($categoryName) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-900"><?= htmlspecialchars($productName) ?></td>
                                <td class="px-4 py-3 text-sm text-right font-medium text-gray-900">MVR <?= number_format($amount, 2) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($notes) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-between">
        <a href="<?= url('admin/assistant') ?>" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md transition">
            Back to AI Assistant
        </a>
        <a href="<?= url('admin/assistant/sandbox') ?>" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-md transition">
            Run Another Analysis
        </a>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        body {
            background: white;
        }
    }
</style>