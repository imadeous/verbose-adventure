<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Review;
use Core\Database\ReportBuilder;

class AdminController extends AdminControllerBase
{
    public function index()
    {

        $ordersLast30Days = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'))
            ->monthly()
            ->where('type', '=', 'income')
            ->withCount('*', 'Total Orders')
            ->generate()['data'];

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
            ->limit(5)->generate()['data'];

        // Fetch expenses and generate report
        $heaviestExpenses = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-t'))
            ->where('type', '=', 'expense')
            ->with('category_id')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->withSum('amount', 'Total')
            ->orderBy('COUNT(category_id)', 'desc') // Use column name instead of alias
            ->limit(5)->generate()['data'];

        $this->view->layout('admin');

        // Fetch recent reviews and generate report
        $recentReviews = Review::query()
            ->orderBy('created_at', 'desc')
            ->limit(5)
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
            ->withAverage('pricing_rating', 'Overall Rating')
            ->withCount('*', 'Total Reviews')
            ->orderBy('SUM(pricing_rating)', 'desc')
            ->groupBy('product_id')
            ->limit(5)->generate()['data'];

        $ratings = [
            'Quality' => $reviewsReport['data'][0]['Quality'] ?? 0,
            'Pricing' => $reviewsReport['data'][0]['Pricing'] ?? 0,
            'Communication' => $reviewsReport['data'][0]['Communication'] ?? 0,
            'Packaging' => $reviewsReport['data'][0]['Packaging'] ?? 0,
            'Delivery' => $reviewsReport['data'][0]['Delivery'] ?? 0,
        ];

        $recommendPercent = $reviewsReport['data'][0]['Recommendation'] ?? 0;

        $overallAvg = array_sum(array_values($ratings)) / count($ratings);

        $ratingStats = [
            'ratings' => $ratings,
            'recommendPercent' => $recommendPercent,
            'overallAvg' => $overallAvg,
            'count' => $reviewsReport['data'][0]['Total Reviews'] ?? 0,
        ];
        // Debugging method to inspect variables
        $this->view->layout('admin');
        $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Home']
            ],
            'ordersLast30Days' => $ordersLast30Days,
            'hottestCategories' => $hottestCategories,
            'heaviestExpenses' => $heaviestExpenses,
            'ratingStats' => $ratingStats,
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

        //get the hottest categories
        $query  = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'))

            ->where('type', '=', 'income')
            ->withCount('*', 'Total Orders');


        $vars = [
            'products' => $query->generate('Top Rated Products', true),
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
