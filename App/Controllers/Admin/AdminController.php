<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Review;
use Core\Database\ReportBuilder;
use Core\Database\ChartBuilder;

class AdminController extends AdminControllerBase
{
    public function index()
    {

        $transactionsChart = ChartBuilder::build('transactions', 'date')
            ->forPeriod('2025-01-01', '2025-07-31')
            ->monthly()
            ->where('type', '=', 'income')
            ->withSum('amount', 'Revenue')
            ->withCount('*', 'Orders')
            // ->withAverage('amount', 'Average')
            ->mixedChart([
                'Revenue' => ['type' => 'line', 'yAxisID' => 'y1', 'borderColor' => '#2563eb', 'fill' => false],
                'Orders' => ['type' => 'bar', 'yAxisID' => 'y', 'backgroundColor' => '#60a5fa'],
                // 'Average' => ['type' => 'line', 'yAxisID' => 'y1', 'borderColor' => '#05011bff', 'fill' => false]
            ]);

        $quarterlyChart = ChartBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-01-01'), date('Y-m-d'))
            ->quarterly()
            ->where('type', '=', 'income')
            ->withSum('amount', 'Total Amount')
            ->colors([
                '#2563eb',
                '#3b82f6',
                '#60a5fa',
                '#93c5fd'
            ])
            ->legend(['display' => false])
            ->pie();

        $thisMonth = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-d'))
            ->where('type', '=', 'income')
            ->withSum('amount', 'Total Amount')
            ->withCount('*', 'Total Orders')
            ->generate()['data'][0] ?? [];

        $lastMonth = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')))
            ->where('type', '=', 'income')
            ->withSum('amount', 'Total Amount')
            ->withCount('*', 'Total Orders')
            ->generate()['data'][0] ?? [];

        // Fetch categories and generate report
        $hottestCategories  = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-t'))
            ->where('type', '=', 'income')
            ->with('category_id')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->withSum('amount', 'Total')
            ->withCount('*', 'Count')
            ->orderBy('COUNT(category_id)', 'desc') // Use column name instead of alias
            ->limit(5)->generate()['data'] ?? [];

        // Fetch expenses and generate report
        $heaviestExpenses = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-t'))
            ->where('type', '=', 'expense')
            ->with('category_id')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->withSum('amount', 'Total')
            ->orderBy('COUNT(category_id)', 'desc') // Use column name instead of alias
            ->limit(5)->generate()['data'] ?? [];

        $this->view->layout('admin');

        // Fetch recent reviews and generate report
        $recentReviews = Review::query()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $reviewsReport = ReportBuilder::build('reviews', 'created_at')
            ->forPeriod(date('2020-01-01'), date('Y-m-t'))
            ->withPercentage('recommendation_score', 'Recommendation')
            ->withAverage('quality_rating', 'Quality')
            ->withAverage('pricing_rating', 'Pricing')
            ->withAverage('communication_rating', 'Communication')
            ->withAverage('packaging_rating', 'Packaging')
            ->withAverage('delivery_rating', 'Delivery')
            ->withCount('*', 'Total Reviews')
            ->generate('Reviews Report', true);

        $topRatedProducts = ReportBuilder::build('reviews', 'created_at')
            ->forPeriod(date('2020-01-01'), date('Y-m-t'))
            ->whereNotNull('product_id')
            ->where('product_id', '!=', '')
            ->with('product_id')
            ->withAverage('quality_rating', 'Overall Rating')
            ->withCount('*', 'Total Reviews')
            ->orderBy('SUM(quality_rating)', 'desc')
            ->groupBy('product_id')
            ->limit(5)->generate()['data'] ?? [];

        $ratings = [
            'Quality' => $reviewsReport['data'][0]['Quality'] ?? 0,
            'Pricing' => $reviewsReport['data'][0]['Pricing'] ?? 0,
            'Communication' => $reviewsReport['data'][0]['Communication'] ?? 0,
            'Packaging' => $reviewsReport['data'][0]['Packaging'] ?? 0,
            'Delivery' => $reviewsReport['data'][0]['Delivery'] ?? 0,
        ];

        $ratingsChart = ChartBuilder::build('reviews', 'created_at')
            ->forPeriod(date('2020-01-01'), date('Y-m-t'))
            ->withAverage('quality_rating', 'Quality')
            ->withAverage('pricing_rating', 'Pricing')
            ->withAverage('communication_rating', 'Communication')
            ->withAverage('packaging_rating', 'Packaging')
            ->withAverage('delivery_rating', 'Delivery')
            ->radar()
            ->legend(['display' => false])
            ->colors(['#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe']);

        $recommendPercent = $reviewsReport['data'][0]['Recommendation'] ?? 0;

        $overallAvg = array_sum(array_values($ratings)) / count($ratings);

        $ratingStats = [
            'ratings' => $ratings,
            'recommendPercent' => $recommendPercent,
            'overallAvg' => $overallAvg,
            'count' => $reviewsReport['data'][0]['Total Reviews'] ?? 0,
        ];

        $this->view->layout('admin');
        $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Home']
            ],
            'transactionsChart' => $transactionsChart->toJson(),
            'quarterlyChart' => $quarterlyChart,
            'ratingsChart' => $ratingsChart->toJson(),
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
            'ratingStats' => $ratingStats,
            'hottestCategories' => $hottestCategories,
            'heaviestExpenses' => $heaviestExpenses,
            'recentReviews' => array_map(fn($row) => new Review($row), $recentReviews),
            'topRatedProducts' => $topRatedProducts,
        ]);
    }

    public function reports()
    {
        // Get modifiers from GET
        $periodStart = $_GET['period_start'] ?? date('Y-m-d');
        $periodEnd = $_GET['period_end'] ?? date('Y-m-d');
        $grouping = $_GET['grouping'] ?? 'daily';
        $type = $_GET['type'] ?? 'all';
        $aggSum = !empty($_GET['aggregate_sum']);
        $aggAvg = !empty($_GET['aggregate_avg']);
        $aggMin = !empty($_GET['aggregate_min']);
        $aggMax = !empty($_GET['aggregate_max']);
        $aggCount = !empty($_GET['aggregate_count']);

        $autoTitle = 'Transactions Report';
        $builder = ReportBuilder::build('transactions', 'date')
            ->forPeriod($periodStart, $periodEnd);

        // Grouping
        switch ($grouping) {
            case 'weekly':
                $builder->weekly();
                break;
            case 'monthly':
                $builder->monthly();
                break;
            case 'quarterly':
                $builder->quarterly();
                break;
            case 'yearly':
                $builder->yearly();
                break;
            default:
                $builder->daily();
                break;
        }

        // Type filter
        if ($type === 'income' || $type === 'expense') {
            $builder->where('type', '=', $type);
        }

        // Aggregates
        if ($aggSum) $builder->withSum('amount', 'Total');
        if ($aggAvg) $builder->withAverage('amount', 'Average');
        if ($aggMin) $builder->withMin('amount', 'Min');
        if ($aggMax) $builder->withMax('amount', 'Max');
        if ($aggCount) $builder->withCount('*', 'Count');

        $report = $builder->generate($autoTitle, true);

        if (!empty($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode($report, JSON_PRETTY_PRINT);
            exit;
        }

        $this->view->layout('admin');
        $this->view('admin/reports/index', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Reports']
            ],
            'report' => $report,
        ]);
    }

    public function debug()
    {
        // Mixed bar-line chart with dynamic data and auto y-axis assignment
        $query =  $reviewsReport = ChartBuilder::build('reviews', 'created_at')
            ->forPeriod(date('2020-01-01'), date('Y-m-t'))
            ->withAverage('quality_rating', 'Quality')
            ->withAverage('pricing_rating', 'Pricing')
            ->withAverage('communication_rating', 'Communication')
            ->withAverage('packaging_rating', 'Packaging')
            ->withAverage('delivery_rating', 'Delivery')
            ->radar();

        $vars = [
            'products' => $query->toJson()
        ];
        // Debugging method to inspect variables
        $this->view->layout('admin');
        $this->view('admin/debug', [
            'title' => 'Debugging',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Debug']
            ],
            'query' => $query->toSql(),
            'vars' => $vars,
        ]);
    }
}
