<?php

namespace App\Controllers\Admin;

use App\Models\Quote;
use Core\Controller;

class QuotesController extends Controller
{
    public function index()
    {
        $quotes = Quote::all();
        $this->view->layout('admin');
        $this->view('admin/quotes/index', [
            'quotes' => $quotes,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Quotes'],
            ],
        ]);
    }

    public function show($id)
    {
        $quote = Quote::find($id);
        $this->view->layout('admin');
        $this->view('admin/quotes/show', [
            'quote' => $quote,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Quotes', 'url' => url('/admin/quotes')],
                ['label' => $quote ? $quote->name : 'Quote'],
            ],
        ]);
    }

    public function destroy($id)
    {
        $quote = Quote::find($id);
        if ($quote) {
            $quote->delete();
        }
        header('Location: ' . url('admin/quotes'));
        exit;
    }
}
