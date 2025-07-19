<?php

namespace App\Controllers;

use App\Models\Quote;
use App\Models\QuoteService;
use Core\Controller;
use Core\View;

class QuotesController extends Controller
{
    // Show the quote form (if needed)

    public function create()
    {
        $this->view('quote');
    }

    // Handle quote form submission
    public function store()
    {
        // Validate required fields
        $required = ['name', 'email', 'phone', 'delivery_address', 'product_type', 'quantity', 'timeline'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                $_SESSION['error'] = 'Please fill all required fields.';
                header('Location: /quote');
                exit;
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

        $_SESSION['success'] = 'Your quote request has been submitted!';
        header('Location: /quote');
        exit;
    }
}
