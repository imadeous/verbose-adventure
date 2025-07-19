<?php

namespace App\Controllers\App;

use App\Models\Quote;
use App\Models\QuoteService;
use Core\Controller;

class QuotesController extends Controller
{
    public function index()
    {
        // Optionally, fetch all quotes for display
        // $quotes = Quote::all();
        // $this->view->quotes = $quotes;
        $this->view->layout('app');
        $this->view('quote'); // expects App/Views/quotes/index.view.php
    }

    // Handle quote form submission
    public function store()
    {
        // Validate required fields
        $required = ['name', 'email', 'phone', 'delivery_address', 'product_type', 'quantity', 'timeline'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                flash('error', "Missing required field: $field");
                $this->redirect('/quote');
                return;
            }
        }

        // Prepare data for Quote
        $quote = new Quote();
        $quote->fill([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'instagram' => $_POST['instagram'] ?? null,
            'delivery_address' => $_POST['delivery_address'],
            'billing_address' => $_POST['billing_address'] ?? null,
            'product_type' => $_POST['product_type'],
            'material' => $_POST['material'] ?? null,
            'quantity' => $_POST['quantity'],
            'timeline' => $_POST['timeline'],
            'description' => $_POST['description'] ?? null,
            'budget' => $_POST['budget'] ?? null,
        ]);
        $quote->save();

        // Handle additional services (many-to-many)
        if (!empty($_POST['services']) && is_array($_POST['services'])) {
            foreach ($_POST['services'] as $service) {
                $qs = new QuoteService();
                $qs->fill([
                    'quote_id' => $quote->id,
                    'service' => $service
                ]);
                $qs->save();
            }
        }

        flash('success', 'Quote saved successfully.');
        $this->redirect('/quotes');
    }
}
