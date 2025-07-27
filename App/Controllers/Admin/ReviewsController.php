<?php

namespace App\Controllers\Admin;

use App\Models\Review;
use Core\AdminControllerBase;
use Core\Database\ReportBuilder;

class ReviewsController extends AdminControllerBase
{
    public function index()
    {
        $reviewReport = ReportBuilder::build('reviews', 'created_at')
            // ->forPeriod(date('Y-m-01'), date('Y-m-t'))
            // ->monthly() // Aggregate for current month
            ->withAverage('recommendation_score', 'Recommendation')
            ->withAverage('quality_rating', 'Quality')
            ->withAverage('pricing_rating', 'Pricing')
            ->withAverage('communication_rating', 'Communication')
            ->withAverage('packaging_rating', 'Packaging')
            ->withAverage('delivery_rating', 'Delivery')
            ->generate('Reviews Report', true);
        $reviews = Review::all();
        $this->view->layout('admin');
        $this->view(
            'admin/reviews/index',
            [
                'breadcrumb' => [
                    ['label' => 'Admin', 'url' => '/admin'],
                    ['label' => 'Reviews', 'url' => '/admin/reviews']
                ],
                'reviews' => $reviews,
                'report' => $reviewReport
            ]
        );
    }

    public function show($id)
    {
        $review = Review::find($id);
        $this->view->layout('admin');
        $this->view('admin/reviews/show', ['review' => $review]);
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
            flash('success', 'Review deleted successfully.');
        } else {
            flash('error', 'Review not found.');
        }
        $this->redirect('/admin/reviews');
    }
}
