<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Helpers\OpenAIClient;
use Core\Database\ReportBuilder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Review;

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

    // SWOT Analysis
    public function swot()
    {
        $data = $this->gatherSWOTData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildSWOTPrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are a business strategy consultant specializing in SWOT analysis. Provide detailed, actionable insights."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'SWOT Analysis',
                'icon' => '🎯',
                'color' => 'blue',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'SWOT Analysis']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate analysis: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
    }

    // Revenue Analysis
    public function revenue()
    {
        $data = $this->gatherRevenueData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildRevenuePrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are a financial analyst specializing in revenue analysis and trends. Provide clear insights with specific recommendations."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'Revenue Analysis',
                'icon' => '💰',
                'color' => 'green',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'Revenue Analysis']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate analysis: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
    }

    // Business Forecast
    public function forecast()
    {
        $data = $this->gatherForecastData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildForecastPrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are a business forecasting expert. Analyze historical data and provide realistic predictions with confidence levels."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'Business Forecast',
                'icon' => '📈',
                'color' => 'purple',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'Business Forecast']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate forecast: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
    }

    // Stock Analysis
    public function stock()
    {
        $data = $this->gatherStockData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildStockPrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are an inventory management specialist. Analyze stock levels and provide restocking recommendations."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'Stock Analysis',
                'icon' => '📦',
                'color' => 'orange',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'Stock Analysis']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate analysis: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
    }

    // CSAT Analysis
    public function csat()
    {
        $data = $this->gatherCSATData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildCSATPrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are a customer experience analyst. Analyze customer reviews and sentiment to provide actionable insights."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'CSAT Analysis',
                'icon' => '⭐',
                'color' => 'pink',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'CSAT Analysis']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate analysis: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
    }

    // Statistics
    public function statistics()
    {
        $data = $this->gatherStatisticsData();

        try {
            $client = OpenAIClient::fromEnv();

            $prompt = $this->buildStatisticsPrompt($data);

            $response = $client->chat([
                ["role" => "system", "content" => "You are a business analytics expert. Interpret key metrics and provide comprehensive insights."],
                ["role" => "user", "content" => $prompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'No response generated';

            $this->view->layout('admin');
            $this->view('admin/assistant/result', [
                'title' => 'Business Statistics',
                'icon' => '📊',
                'color' => 'indigo',
                'aiResponse' => $aiResponse,
                'rawData' => $data,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'Statistics']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate statistics: ' . $e->getMessage());
            $this->redirect('/admin/assistant');
        }
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

    // === Data Gathering Methods for Individual Analyses ===

    private function gatherSWOTData(): array
    {
        $report = new ReportBuilder();

        return [
            'totalRevenue' => $report->totalRevenue() ?? 0,
            'totalOrders' => $report->totalOrders() ?? 0,
            'avgOrderValue' => $report->averageOrderValue() ?? 0,
            'topProducts' => $report->topProductsByRevenue(5) ?? [],
            'categories' => Category::all() ?? [],
            'products' => Product::all() ?? [],
            'lowStockProducts' => Product::query()->where('stock', '<', 10)->get() ?? [],
            'recentTransactions' => Transaction::query()->orderBy('date', 'DESC')->limit(20)->get() ?? []
        ];
    }

    private function gatherRevenueData(): array
    {
        $report = new ReportBuilder();

        return [
            'totalRevenue' => $report->totalRevenue() ?? 0,
            'monthlyRevenue' => $report->revenueByMonth() ?? [],
            'categoryRevenue' => $report->revenueByCategoryWithNames() ?? [],
            'productRevenue' => $report->topProductsByRevenue(10) ?? [],
            'totalOrders' => $report->totalOrders() ?? 0,
            'avgOrderValue' => $report->averageOrderValue() ?? 0,
            'recentTransactions' => Transaction::query()->orderBy('date', 'DESC')->limit(30)->get() ?? []
        ];
    }

    private function gatherForecastData(): array
    {
        $report = new ReportBuilder();

        return [
            'monthlyRevenue' => $report->revenueByMonth() ?? [],
            'monthlyOrders' => $report->ordersByMonth() ?? [],
            'categoryRevenue' => $report->revenueByCategoryWithNames() ?? [],
            'productRevenue' => $report->topProductsByRevenue(10) ?? [],
            'recentTrends' => Transaction::query()->orderBy('date', 'DESC')->limit(90)->get() ?? []
        ];
    }

    private function gatherStockData(): array
    {
        $products = Product::all() ?? [];
        $lowStock = [];
        $goodStock = [];
        $overStock = [];

        foreach ($products as $product) {
            $stock = is_array($product) ? ($product['stock'] ?? 0) : ($product->stock ?? 0);
            $name = is_array($product) ? ($product['name'] ?? 'Unknown') : ($product->name ?? 'Unknown');
            $id = is_array($product) ? ($product['id'] ?? 0) : ($product->id ?? 0);

            $productInfo = ['id' => $id, 'name' => $name, 'stock' => $stock];

            if ($stock < 10) {
                $lowStock[] = $productInfo;
            } elseif ($stock > 100) {
                $overStock[] = $productInfo;
            } else {
                $goodStock[] = $productInfo;
            }
        }

        $report = new ReportBuilder();

        return [
            'lowStock' => $lowStock,
            'goodStock' => $goodStock,
            'overStock' => $overStock,
            'totalProducts' => count($products),
            'topSelling' => $report->topProductsByRevenue(10) ?? []
        ];
    }

    private function gatherCSATData(): array
    {
        $reviews = Review::all() ?? [];
        $ratings = [];
        $comments = [];

        $totalRating = 0;
        $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($reviews as $review) {
            $rating = is_array($review) ? ($review['rating'] ?? 0) : ($review->rating ?? 0);
            $comment = is_array($review) ? ($review['review_text'] ?? '') : ($review->review_text ?? '');
            $productId = is_array($review) ? ($review['product_id'] ?? null) : ($review->product_id ?? null);

            if ($rating > 0) {
                $totalRating += $rating;
                $ratingCounts[$rating]++;
            }

            if (!empty($comment)) {
                $comments[] = [
                    'rating' => $rating,
                    'comment' => $comment,
                    'product_id' => $productId
                ];
            }
        }

        $avgRating = count($reviews) > 0 ? $totalRating / count($reviews) : 0;

        return [
            'averageRating' => $avgRating,
            'totalReviews' => count($reviews),
            'ratingDistribution' => $ratingCounts,
            'recentComments' => array_slice($comments, 0, 20),
            'positiveReviews' => array_filter($reviews, function ($r) {
                $rating = is_array($r) ? ($r['rating'] ?? 0) : ($r->rating ?? 0);
                return $rating >= 4;
            }),
            'negativeReviews' => array_filter($reviews, function ($r) {
                $rating = is_array($r) ? ($r['rating'] ?? 0) : ($r->rating ?? 0);
                return $rating <= 2;
            })
        ];
    }

    private function gatherStatisticsData(): array
    {
        $report = new ReportBuilder();

        return [
            'totalRevenue' => $report->totalRevenue() ?? 0,
            'totalOrders' => $report->totalOrders() ?? 0,
            'avgOrderValue' => $report->averageOrderValue() ?? 0,
            'monthlyRevenue' => $report->revenueByMonth() ?? [],
            'monthlyOrders' => $report->ordersByMonth() ?? [],
            'categoryRevenue' => $report->revenueByCategoryWithNames() ?? [],
            'productRevenue' => $report->topProductsByRevenue(10) ?? [],
            'totalProducts' => count(Product::all() ?? []),
            'totalCategories' => count(Category::all() ?? []),
            'lowStockCount' => count(Product::query()->where('stock', '<', 10)->get() ?? [])
        ];
    }

    // === Prompt Building Methods for Individual Analyses ===

    private function buildSWOTPrompt(array $data): string
    {
        $prompt = "# SWOT Analysis Request\n\n";
        $prompt .= "Please conduct a comprehensive SWOT analysis based on the following business data:\n\n";

        $prompt .= "## Business Overview\n";
        $prompt .= "- Total Revenue: $" . number_format($data['totalRevenue'], 2) . "\n";
        $prompt .= "- Total Orders: {$data['totalOrders']}\n";
        $prompt .= "- Average Order Value: $" . number_format($data['avgOrderValue'], 2) . "\n";
        $prompt .= "- Total Products: " . count($data['products']) . "\n";
        $prompt .= "- Total Categories: " . count($data['categories']) . "\n";
        $prompt .= "- Low Stock Products: " . count($data['lowStockProducts']) . "\n\n";

        $prompt .= "## Top Performing Products\n";
        foreach (array_slice($data['topProducts'], 0, 5) as $product) {
            $prompt .= "- {$product['name']}: $" . number_format($product['revenue'], 2) . "\n";
        }

        $prompt .= "\n## Analysis Required\n";
        $prompt .= "Provide a detailed SWOT analysis covering:\n";
        $prompt .= "1. **Strengths**: Internal positive attributes and resources\n";
        $prompt .= "2. **Weaknesses**: Internal limitations and areas needing improvement\n";
        $prompt .= "3. **Opportunities**: External factors to capitalize on\n";
        $prompt .= "4. **Threats**: External challenges and risks\n\n";
        $prompt .= "Include specific recommendations for each category.\n";

        return $prompt;
    }

    private function buildRevenuePrompt(array $data): string
    {
        $prompt = "# Revenue Analysis Request\n\n";
        $prompt .= "Please analyze the following revenue data and provide insights:\n\n";

        $prompt .= "## Key Metrics\n";
        $prompt .= "- Total Revenue: $" . number_format($data['totalRevenue'], 2) . "\n";
        $prompt .= "- Total Orders: {$data['totalOrders']}\n";
        $prompt .= "- Average Order Value: $" . number_format($data['avgOrderValue'], 2) . "\n\n";

        if (!empty($data['monthlyRevenue'])) {
            $prompt .= "## Monthly Revenue Trends\n";
            foreach ($data['monthlyRevenue'] as $month) {
                $prompt .= "- {$month['month']}: $" . number_format($month['revenue'], 2) . "\n";
            }
            $prompt .= "\n";
        }

        if (!empty($data['categoryRevenue'])) {
            $prompt .= "## Revenue by Category\n";
            foreach ($data['categoryRevenue'] as $cat) {
                $prompt .= "- {$cat['category_name']}: $" . number_format($cat['revenue'], 2) . "\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Analysis Required\n";
        $prompt .= "1. Identify revenue trends and patterns\n";
        $prompt .= "2. Highlight areas of growth and decline\n";
        $prompt .= "3. Provide recommendations to increase revenue\n";
        $prompt .= "4. Suggest strategies for improving average order value\n";

        return $prompt;
    }

    private function buildForecastPrompt(array $data): string
    {
        $prompt = "# Business Forecast Request\n\n";
        $prompt .= "Based on historical data, provide realistic forecasts and predictions:\n\n";

        if (!empty($data['monthlyRevenue'])) {
            $prompt .= "## Historical Revenue (Last 12 Months)\n";
            foreach ($data['monthlyRevenue'] as $month) {
                $prompt .= "- {$month['month']}: $" . number_format($month['revenue'], 2) . "\n";
            }
            $prompt .= "\n";
        }

        if (!empty($data['monthlyOrders'])) {
            $prompt .= "## Historical Orders\n";
            foreach ($data['monthlyOrders'] as $month) {
                $prompt .= "- {$month['month']}: {$month['orders']} orders\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Forecast Required\n";
        $prompt .= "1. Predict next 3 months revenue with confidence levels\n";
        $prompt .= "2. Forecast expected order volume\n";
        $prompt .= "3. Identify seasonal patterns and trends\n";
        $prompt .= "4. Provide best-case, realistic, and worst-case scenarios\n";
        $prompt .= "5. Recommend preparation strategies\n";

        return $prompt;
    }

    private function buildStockPrompt(array $data): string
    {
        $prompt = "# Stock Analysis Request\n\n";
        $prompt .= "Analyze current inventory levels and provide recommendations:\n\n";

        $prompt .= "## Inventory Overview\n";
        $prompt .= "- Total Products: {$data['totalProducts']}\n";
        $prompt .= "- Low Stock Items: " . count($data['lowStock']) . "\n";
        $prompt .= "- Good Stock Items: " . count($data['goodStock']) . "\n";
        $prompt .= "- Overstock Items: " . count($data['overStock']) . "\n\n";

        if (!empty($data['lowStock'])) {
            $prompt .= "## Low Stock Products (Critical)\n";
            foreach (array_slice($data['lowStock'], 0, 10) as $product) {
                $prompt .= "- {$product['name']}: {$product['stock']} units\n";
            }
            $prompt .= "\n";
        }

        if (!empty($data['topSelling'])) {
            $prompt .= "## Top Selling Products\n";
            foreach (array_slice($data['topSelling'], 0, 5) as $product) {
                $prompt .= "- {$product['name']}: $" . number_format($product['revenue'], 2) . " ({$product['orders']} orders)\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Analysis Required\n";
        $prompt .= "1. Identify urgent restocking needs\n";
        $prompt .= "2. Recommend optimal stock levels\n";
        $prompt .= "3. Suggest inventory management strategies\n";
        $prompt .= "4. Identify slow-moving items to discount\n";

        return $prompt;
    }

    private function buildCSATPrompt(array $data): string
    {
        $prompt = "# Customer Satisfaction (CSAT) Analysis Request\n\n";
        $prompt .= "Analyze customer reviews and sentiment:\n\n";

        $prompt .= "## Review Metrics\n";
        $prompt .= "- Average Rating: " . number_format($data['averageRating'], 2) . " / 5.0\n";
        $prompt .= "- Total Reviews: {$data['totalReviews']}\n";
        $prompt .= "- Positive Reviews (4-5⭐): " . count($data['positiveReviews']) . "\n";
        $prompt .= "- Negative Reviews (1-2⭐): " . count($data['negativeReviews']) . "\n\n";

        $prompt .= "## Rating Distribution\n";
        foreach ($data['ratingDistribution'] as $rating => $count) {
            $prompt .= "- {$rating}⭐: {$count} reviews\n";
        }
        $prompt .= "\n";

        if (!empty($data['recentComments'])) {
            $prompt .= "## Recent Customer Comments\n";
            foreach (array_slice($data['recentComments'], 0, 15) as $comment) {
                $prompt .= "- ({$comment['rating']}⭐) " . substr($comment['comment'], 0, 100) . "...\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Analysis Required\n";
        $prompt .= "1. Analyze overall customer sentiment\n";
        $prompt .= "2. Identify common themes in positive and negative reviews\n";
        $prompt .= "3. Highlight specific areas for improvement\n";
        $prompt .= "4. Provide actionable recommendations to improve CSAT\n";
        $prompt .= "5. Suggest response strategies for negative feedback\n";

        return $prompt;
    }

    private function buildStatisticsPrompt(array $data): string
    {
        $prompt = "# Comprehensive Business Statistics Analysis\n\n";
        $prompt .= "Please provide detailed insights on all key business metrics:\n\n";

        $prompt .= "## Overall Metrics\n";
        $prompt .= "- Total Revenue: $" . number_format($data['totalRevenue'], 2) . "\n";
        $prompt .= "- Total Orders: {$data['totalOrders']}\n";
        $prompt .= "- Average Order Value: $" . number_format($data['avgOrderValue'], 2) . "\n";
        $prompt .= "- Total Products: {$data['totalProducts']}\n";
        $prompt .= "- Total Categories: {$data['totalCategories']}\n";
        $prompt .= "- Low Stock Items: {$data['lowStockCount']}\n\n";

        if (!empty($data['monthlyRevenue'])) {
            $prompt .= "## Monthly Performance\n";
            foreach ($data['monthlyRevenue'] as $month) {
                $orders = 0;
                foreach ($data['monthlyOrders'] as $mo) {
                    if ($mo['month'] === $month['month']) {
                        $orders = $mo['orders'];
                        break;
                    }
                }
                $prompt .= "- {$month['month']}: $" . number_format($month['revenue'], 2) . " ({$orders} orders)\n";
            }
            $prompt .= "\n";
        }

        if (!empty($data['categoryRevenue'])) {
            $prompt .= "## Category Performance\n";
            foreach ($data['categoryRevenue'] as $cat) {
                $prompt .= "- {$cat['category_name']}: $" . number_format($cat['revenue'], 2) . "\n";
            }
            $prompt .= "\n";
        }

        $prompt .= "## Analysis Required\n";
        $prompt .= "1. Comprehensive overview of business health\n";
        $prompt .= "2. Key performance indicators (KPIs) assessment\n";
        $prompt .= "3. Growth trends and patterns\n";
        $prompt .= "4. Areas of concern and opportunities\n";
        $prompt .= "5. Strategic recommendations for improvement\n";

        return $prompt;
    }
}
