<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Helpers\OpenAIClient;
use Core\Database\ReportBuilder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;

class AssistantController extends AdminController
{
    public function index()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/index', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant']
            ]
        ]);
    }

    public function analyze()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/analyze', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                ['label' => 'Business Analysis']
            ]
        ]);
    }

    public function sandbox()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/sandbox', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                ['label' => 'AI Sandbox']
            ]
        ]);
    }

    public function runSandbox()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Invalid request method.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        // Get form data
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $customPrompt = $_POST['custom_prompt'] ?? '';

        if (!$startDate || !$endDate) {
            flash('error', 'Please select a date range.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        if (empty(trim($customPrompt))) {
            flash('error', 'Please provide instructions for the AI.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        // Get all transactions for the period
        $transactions = Transaction::query()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderBy('date', 'ASC')
            ->get();

        if (empty($transactions)) {
            flash('error', 'No transactions found for the selected period.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        // Generate AI response
        try {
            $client = OpenAIClient::fromEnv();

            $systemPrompt = "You are a helpful business assistant with expertise in data analysis, financial analysis, and business insights. Analyze the provided transaction data and respond to the user's request with clear, actionable insights.";

            $userPrompt = $this->buildSandboxPrompt($transactions, $customPrompt, $startDate, $endDate);

            $response = $client->chat([
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $userPrompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? null;

            if (!$aiResponse) {
                throw new \Exception('No response generated from AI');
            }

            // Render result page
            $this->view->layout('admin');
            $this->view('admin/assistant/sandbox-result', [
                'aiResponse' => $aiResponse,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'customPrompt' => $customPrompt,
                'transactionCount' => count($transactions),
                'transactions' => $transactions,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'AI Sandbox', 'url' => url('admin/assistant/sandbox')],
                    ['label' => 'Result']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate response: ' . $e->getMessage());
            $this->redirect('/admin/assistant/sandbox');
        }
    }

    private function buildSandboxPrompt(array $transactions, string $customPrompt, string $startDate, string $endDate): string
    {
        $prompt = "# Custom Analysis Request\n\n";
        $prompt .= "**Analysis Period:** {$startDate} to {$endDate}\n";
        $prompt .= "**Total Transactions:** " . count($transactions) . "\n\n";

        $prompt .= "## User Request\n";
        $prompt .= $customPrompt . "\n\n";

        $prompt .= "## Transaction Data\n\n";
        $prompt .= "| Date | Type | Category | Product | Amount | Notes |\n";
        $prompt .= "|------|------|----------|---------|--------|-------|\n";

        foreach ($transactions as $transaction) {
            $date = is_array($transaction) ? $transaction['date'] : $transaction->date;
            $type = is_array($transaction) ? ($transaction['type'] ?? 'N/A') : ($transaction->type ?? 'N/A');
            $categoryId = is_array($transaction) ? ($transaction['category_id'] ?? null) : ($transaction->category_id ?? null);
            $productId = is_array($transaction) ? ($transaction['product_id'] ?? null) : ($transaction->product_id ?? null);
            $amount = is_array($transaction) ? ($transaction['amount'] ?? 0) : ($transaction->amount ?? 0);
            $notes = is_array($transaction) ? ($transaction['notes'] ?? '') : ($transaction->notes ?? '');

            // Get category name
            $categoryName = 'N/A';
            if ($categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    $categoryName = is_array($category) ? $category['name'] : $category->name;
                }
            }

            // Get product name
            $productName = 'N/A';
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $productName = is_array($product) ? $product['name'] : $product->name;
                }
            }

            $prompt .= "| {$date} | {$type} | {$categoryName} | {$productName} | \${$amount} | {$notes} |\n";
        }

        $prompt .= "\n## Instructions\n";
        $prompt .= "Based on the transaction data above, please respond to the user's request. Provide clear, detailed insights with specific data points when relevant. Use markdown formatting for better readability.\n";

        return $prompt;
    }


    public function generateAnalysis()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Invalid request method.');
            $this->redirect('/admin/assistant/analyze');
            return;
        }

        // Get form data
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $analysisTypes = $_POST['analysis_types'] ?? [];

        if (!$startDate || !$endDate) {
            flash('error', 'Please select a date range.');
            $this->redirect('/admin/assistant/analyze');
            return;
        }

        if (empty($analysisTypes)) {
            flash('error', 'Please select at least one analysis type.');
            $this->redirect('/admin/assistant/analyze');
            return;
        }

        // Gather business data
        $businessData = $this->gatherBusinessData($startDate, $endDate, $analysisTypes);

        // Generate AI analysis
        try {
            $client = OpenAIClient::fromEnv();

            $systemPrompt = "You are an expert business analyst specializing in e-commerce and retail businesses. Provide detailed, actionable insights with specific recommendations. Use data-driven analysis and present findings in a clear, professional manner with proper formatting using markdown.";

            $userPrompt = $this->buildAnalysisPrompt($businessData, $analysisTypes, $startDate, $endDate);

            $response = $client->chat([
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $userPrompt]
            ]);

            $analysis = $response['choices'][0]['message']['content'] ?? null;

            if (!$analysis) {
                throw new \Exception('No analysis generated from AI');
            }

            // Render analysis result page
            $this->view->layout('admin');
            $this->view('admin/assistant/analysis-result', [
                'analysis' => $analysis,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'analysisTypes' => $analysisTypes,
                'businessData' => $businessData,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'Business Analysis', 'url' => url('admin/assistant/analyze')],
                    ['label' => 'Analysis Report']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate analysis: ' . $e->getMessage());
            $this->redirect('/admin/assistant/analyze');
        }
    }

    private function gatherBusinessData(string $startDate, string $endDate, array $analysisTypes): array
    {
        $data = [
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];

        // Revenue Analysis
        if (in_array('revenue', $analysisTypes)) {
            $revenueData = ReportBuilder::build('transactions', 'date')
                ->where('type', '=', 'income')
                ->where('date', '>=', $startDate)
                ->where('date', '<=', $endDate)
                ->daily()
                ->withSum('amount', 'Revenue')
                ->withCount('*', 'Orders')
                ->generate();

            $totalRevenue = array_sum(array_column($revenueData['data'], 'Revenue'));
            $totalOrders = array_sum(array_column($revenueData['data'], 'Orders'));
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            $data['revenue'] = [
                'total' => $totalRevenue,
                'total_orders' => $totalOrders,
                'average_order_value' => $avgOrderValue,
                'daily_breakdown' => $revenueData['data']
            ];
        }

        // Stock Analysis
        if (in_array('stock', $analysisTypes)) {
            $products = Product::all();
            $totalProducts = count($products);
            $totalStock = 0;
            $lowStock = [];
            $outOfStock = [];

            foreach ($products as $product) {
                $productId = is_array($product) ? $product['id'] : $product->id;
                $productName = is_array($product) ? $product['name'] : $product->name;

                $variants = Product::getVariants($productId);
                foreach ($variants as $variant) {
                    $stock = $variant['stock_quantity'] ?? 0;
                    $totalStock += $stock;

                    if ($stock == 0) {
                        $outOfStock[] = [
                            'product' => $productName,
                            'variant' => $variant['sku'] ?? 'N/A'
                        ];
                    } elseif ($stock <= 10) {
                        $lowStock[] = [
                            'product' => $productName,
                            'variant' => $variant['sku'] ?? 'N/A',
                            'stock' => $stock
                        ];
                    }
                }
            }

            $data['stock'] = [
                'total_products' => $totalProducts,
                'total_stock_units' => $totalStock,
                'low_stock_items' => $lowStock,
                'out_of_stock_items' => $outOfStock
            ];
        }

        // Category Performance
        if (in_array('categories', $analysisTypes)) {
            $categories = Category::all();
            $categoryPerformance = [];

            foreach ($categories as $category) {
                $stats = ReportBuilder::build('transactions', 'date')
                    ->where('type', '=', 'income')
                    ->where('category_id', '=', $category['id'])
                    ->where('date', '>=', $startDate)
                    ->where('date', '<=', $endDate)
                    ->withSum('amount', 'Revenue')
                    ->withCount('*', 'Orders')
                    ->generate()['data'][0] ?? [];

                $categoryPerformance[] = [
                    'name' => $category['name'],
                    'revenue' => $stats['Revenue'] ?? 0,
                    'orders' => $stats['Orders'] ?? 0
                ];
            }

            usort($categoryPerformance, fn($a, $b) => $b['revenue'] <=> $a['revenue']);
            $data['categories'] = $categoryPerformance;
        }

        // Product Performance
        if (in_array('products', $analysisTypes)) {
            $products = Product::all();
            $productPerformance = [];

            foreach ($products as $product) {
                $productId = is_array($product) ? $product['id'] : $product->id;
                $productName = is_array($product) ? $product['name'] : $product->name;

                $stats = ReportBuilder::build('transactions', 'date')
                    ->where('type', '=', 'income')
                    ->where('product_id', '=', $productId)
                    ->where('date', '>=', $startDate)
                    ->where('date', '<=', $endDate)
                    ->withSum('amount', 'Revenue')
                    ->withCount('*', 'Orders')
                    ->generate()['data'][0] ?? [];

                $productPerformance[] = [
                    'name' => $productName,
                    'revenue' => $stats['Revenue'] ?? 0,
                    'orders' => $stats['Orders'] ?? 0
                ];
            }

            usort($productPerformance, fn($a, $b) => $b['revenue'] <=> $a['revenue']);
            $data['products'] = array_slice($productPerformance, 0, 20); // Top 20
        }

        return $data;
    }

    private function buildAnalysisPrompt(array $data, array $types, string $startDate, string $endDate): string
    {
        $prompt = "# Business Analysis Request\n\n";
        $prompt .= "**Analysis Period:** {$startDate} to {$endDate}\n\n";
        $prompt .= "**Requested Analysis Types:** " . implode(', ', array_map('ucfirst', $types)) . "\n\n";
        $prompt .= "## Business Data\n\n";

        if (isset($data['revenue'])) {
            $prompt .= "### Revenue Metrics\n";
            $prompt .= "- Total Revenue: $" . number_format($data['revenue']['total'], 2) . "\n";
            $prompt .= "- Total Orders: " . $data['revenue']['total_orders'] . "\n";
            $prompt .= "- Average Order Value: $" . number_format($data['revenue']['average_order_value'], 2) . "\n\n";
        }

        if (isset($data['stock'])) {
            $prompt .= "### Inventory Status\n";
            $prompt .= "- Total Products: " . $data['stock']['total_products'] . "\n";
            $prompt .= "- Total Stock Units: " . $data['stock']['total_stock_units'] . "\n";
            $prompt .= "- Low Stock Items: " . count($data['stock']['low_stock_items']) . "\n";
            $prompt .= "- Out of Stock Items: " . count($data['stock']['out_of_stock_items']) . "\n\n";
        }

        if (isset($data['categories'])) {
            $prompt .= "### Category Performance (Top 5)\n";
            foreach (array_slice($data['categories'], 0, 5) as $cat) {
                $prompt .= "- {$cat['name']}: $" . number_format($cat['revenue'], 2) . " ({$cat['orders']} orders)\n";
            }
            $prompt .= "\n";
        }

        if (isset($data['products'])) {
            $prompt .= "### Product Performance (Top 10)\n";
            foreach (array_slice($data['products'], 0, 10) as $prod) {
                $prompt .= "- {$prod['name']}: $" . number_format($prod['revenue'], 2) . " ({$prod['orders']} orders)\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Analysis Requirements\n\n";
        $prompt .= "Based on the data above, please provide:\n\n";

        if (in_array('revenue', $types)) {
            $prompt .= "1. **Revenue Analysis**: Analyze revenue trends, identify patterns, and assess financial health.\n";
        }
        if (in_array('swot', $types)) {
            $prompt .= "2. **SWOT Analysis**: Identify Strengths, Weaknesses, Opportunities, and Threats.\n";
        }
        if (in_array('stock', $types)) {
            $prompt .= "3. **Stock Analysis**: Evaluate inventory management, identify issues, and recommend optimizations.\n";
        }
        if (in_array('forecast', $types)) {
            $prompt .= "4. **Forecasts**: Provide revenue and sales projections for the next period.\n";
        }
        if (in_array('comparison', $types)) {
            $prompt .= "5. **Comparisons**: Compare product and category performance to identify winners and losers.\n";
        }
        if (in_array('statistics', $types)) {
            $prompt .= "6. **Comprehensive Statistics**: Deep dive into all available metrics with insights.\n";
        }

        $prompt .= "\n## Expected Output\n\n";
        $prompt .= "Please structure your analysis with:\n";
        $prompt .= "- Clear headings and sections\n";
        $prompt .= "- Data-driven insights with specific numbers\n";
        $prompt .= "- Actionable recommendations\n";
        $prompt .= "- Tips to improve profitability\n";
        $prompt .= "- Warning signs if any\n";
        $prompt .= "- Use markdown formatting for better readability\n";

        return $prompt;
    }
}
