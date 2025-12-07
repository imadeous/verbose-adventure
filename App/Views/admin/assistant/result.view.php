<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <span class="text-3xl"><?= $icon ?></span>
                    <?= htmlspecialchars($title) ?>
                </h2>
                <p class="text-sm text-gray-600">AI-powered insights generated just for you</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>
                <a href="<?= url('admin/assistant') ?>" class="px-4 py-2 bg-<?= $color ?>-600 hover:bg-<?= $color ?>-700 text-white rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Assistant
                </a>
            </div>
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
            $html = preg_replace('/^#### (.+)$/m', '<h4 class="text-base font-bold mt-3 mb-2">$1</h4>', $html);
            $html = preg_replace('/^### (.+)$/m', '<h3 class="text-lg font-bold mt-4 mb-2">$1</h3>', $html);
            $html = preg_replace('/^## (.+)$/m', '<h2 class="text-xl font-bold mt-6 mb-3">$1</h2>', $html);
            $html = preg_replace('/^# (.+)$/m', '<h1 class="text-2xl font-bold mt-8 mb-4">$1</h1>', $html);

            // Bold and italic
            $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-semibold">$1</strong>', $html);
            $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);

            // Lists
            $html = preg_replace('/^\- (.+)$/m', '<li class="ml-4 mb-1">$1</li>', $html);
            $html = preg_replace('/^(\d+)\. (.+)$/m', '<li class="ml-4 mb-1">$2</li>', $html);

            // Wrap consecutive list items
            $html = preg_replace('/(<li.*?<\/li>\n?)+/s', '<ul class="list-disc my-3 space-y-1">$0</ul>', $html);

            // Paragraphs
            $html = preg_replace('/\n\n/', '</p><p class="mb-3">', $html);
            $html = '<p class="mb-3">' . $html . '</p>';

            // Code blocks
            $html = preg_replace('/```(.+?)```/s', '<pre class="bg-gray-100 p-3 rounded my-3 overflow-x-auto"><code>$1</code></pre>', $html);
            $html = preg_replace('/`(.+?)`/', '<code class="bg-gray-100 px-2 py-1 rounded text-sm">$1</code>', $html);

            // Line breaks
            $html = nl2br($html);

            echo $html;
            ?>
        </div>
    </div>

    <!-- Raw Data Section (Collapsible) -->
    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ showData: false }">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Raw Data</h3>
            <button @click="showData = !showData" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-sm transition">
                <span x-show="!showData">Show Data</span>
                <span x-show="showData">Hide Data</span>
            </button>
        </div>

        <div x-show="showData" x-collapse>
            <div class="bg-gray-50 rounded p-4 overflow-x-auto">
                <pre class="text-xs text-gray-700"><?= htmlspecialchars(print_r($rawData, true)) ?></pre>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-center gap-4">
        <a href="<?= url('admin/assistant') ?>" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-md transition shadow-md font-medium">
            Run Another Analysis
        </a>
    </div>
</div>

<style>
    @media print {

        .no-print,
        button,
        a[href] {
            display: none !important;
        }

        body {
            background: white;
        }
    }
</style>