<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Review;
use Core\Database\ReportBuilder;

class AdminController extends AdminControllerBase
{
    public function index()
    {

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
            'ratingStats' => $ratingStats,
            'recentReviews' => array_map(fn($row) => new Review($row), $recentReviews),
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
            ->forPeriod(date('Y-m-01'), date('Y-m-t'))
            ->where('type', '=', 'income')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->withSum('amount', 'total_income')
            ->orderBy('total_income', 'desc')
            ->limit(5);

        $vars = [
            'hottestCategories' => $query->get(),
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
