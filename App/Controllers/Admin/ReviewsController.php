<?php

namespace App\Controllers\Admin;

use App\Models\Review;
use Core\AdminControllerBase;

class ReviewsController extends AdminControllerBase
{
    public function index()
    {
        $reviews = Review::all();
        $this->view->layout('admin');
        $this->view('admin/reviews/index', ['reviews' => $reviews]);
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
