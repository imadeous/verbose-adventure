<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use Core\Database\ReportBuilder;

class AdminController extends AdminControllerBase
{
    public function index()
    {
        // Set the layout for the admin dashboard
        $this->view->layout('admin'); // uses App/Views/layouts/admin.php

        // Fetch all reviews
        $allReviews = \App\Models\Review::all();

        // Sort reviews by created_at descending and get the latest 3
        usort($allReviews, function ($a, $b) {
            return strtotime($b->created_at) <=> strtotime($a->created_at);
        });
        $recentReviews = array_slice($allReviews, 0, 3);

        // Calculate recommendation percentage
        $totalReviews = count($allReviews);
        $sumRecommend = 0;
        $sumQuality = $sumPricing = $sumCommunication = $sumPackaging = $sumDelivery = 0;
        foreach ($allReviews as $review) {
            $sumRecommend += (float)($review->recommendation_score ?? 0);
            $sumQuality += (float)($review->quality_rating ?? 0);
            $sumPricing += (float)($review->pricing_rating ?? 0);
            $sumCommunication += (float)($review->communication_rating ?? 0);
            $sumPackaging += (float)($review->packaging_rating ?? 0);
            $sumDelivery += (float)($review->delivery_rating ?? 0);
        }
        $recommendPercent = $totalReviews > 0 ? round(($sumRecommend / ($totalReviews * 10)) * 100) : 0;

        // Calculate averages
        $avgQuality = $totalReviews > 0 ? $sumQuality / $totalReviews : 0;
        $avgPricing = $totalReviews > 0 ? $sumPricing / $totalReviews : 0;
        $avgCommunication = $totalReviews > 0 ? $sumCommunication / $totalReviews : 0;
        $avgPackaging = $totalReviews > 0 ? $sumPackaging / $totalReviews : 0;
        $avgDelivery = $totalReviews > 0 ? $sumDelivery / $totalReviews : 0;
        $overallAvg = $totalReviews > 0 ? round((($avgQuality + $avgPricing + $avgCommunication + $avgPackaging + $avgDelivery) / 5), 2) : 0;

        // Prepare category averages for insights
        $matrices = [
            ['label' => 'Product Quality', 'score' => round($avgQuality, 1)],
            ['label' => 'Pricing', 'score' => round($avgPricing, 1)],
            ['label' => 'Communication', 'score' => round($avgCommunication, 1)],
            ['label' => 'Packaging', 'score' => round($avgPackaging, 1)],
            ['label' => 'Delivery', 'score' => round($avgDelivery, 1)],
        ];

        // Render the view using section/yield system
        $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')]
            ],
            'recentReviews' => $recentReviews,
            'recommendPercent' => $recommendPercent,
            'overallAvg' => $overallAvg,
            'matrices' => $matrices,
            'totalReviews' => $totalReviews
        ]);
    }

    public function reports()
    {
        // Get modifiers from GET
        $periodStart = $_GET['period_start'] ?? date('Y-m-01');
        $periodEnd = $_GET['period_end'] ?? date('Y-m-t');
        $grouping = $_GET['grouping'] ?? 'daily';
        $type = $_GET['type'] ?? 'all';
        $aggSum = !empty($_GET['aggregate_sum']);
        $aggAvg = !empty($_GET['aggregate_avg']);
        $aggMin = !empty($_GET['aggregate_min']);
        $aggMax = !empty($_GET['aggregate_max']);

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

        $report = $builder->withCount()->generate($autoTitle, true);

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
