<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Review;
use Core\Database\ReportBuilder;

class AdminController extends AdminControllerBase
{
    public function index()
    {
        $this->view->layout('admin');

        // Use ReportBuilder for review statistics
        $reviewStats = ReportBuilder::build('reviews', 'created_at')
            ->forPeriod('2000-01-01', date('Y-m-d'))
            ->withCount('*', 'Total Reviews')
            ->withPercentage('recommendation_score', 'Total Recommendations', 10)
            ->withAverage('quality_rating', 'Average Quality')
            ->withAverage('pricing_rating', 'Average Pricing')
            ->withAverage('communication_rating', 'Average Communication')
            ->withAverage('packaging_rating', 'Average Packaging')
            ->withAverage('delivery_rating', 'Average Delivery')
            ->generate('Review Statistics', true);

        // Get recent reviews (latest 3) using Review model
        $recentReviews = Review::query()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Ensure recentReviews is an array of Review objects
        if (is_array($recentReviews) && !empty($recentReviews) && is_array($recentReviews[0])) {
            $recentReviews = array_map(function ($row) {
                return (object)$row;
            }, $recentReviews);
        }

        $matrices = [
            ['label' => 'Product Quality', 'score' => $reviewStats[0]['Average Quality'] ?? 0],
            ['label' => 'Pricing', 'score' => $reviewStats[0]['Average Pricing'] ?? 0],
            ['label' => 'Communication', 'score' => $reviewStats[0]['Average Communication'] ?? 0],
            ['label' => 'Packaging', 'score' => $reviewStats[0]['Average Packaging'] ?? 0],
            ['label' => 'Delivery', 'score' => $reviewStats[0]['Average Delivery'] ?? 0],
        ];

        $overallAvg = !empty($matrices)
            ? round(array_sum(array_column($matrices, 'score')) / count($matrices), 2)
            : 0;
        $totalReviews = $reviewStats[0]['Total Reviews'] ?? 0;

        $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')]
            ],
            'recentReviews' => $recentReviews,
            'recommendPercent' => $reviewStats[0]['Total Recommendations'] ?? 0,
            'overallAvg' => $overallAvg,
            'matrices' => $matrices,
            'totalReviews' => $totalReviews,
            'reviewStats' => $reviewStats[0] ?? []
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
}
