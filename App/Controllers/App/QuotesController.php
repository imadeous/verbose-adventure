<?php

namespace App\Controllers\App;

use App\Models\Quote;
use App\Models\QuoteService;
use Core\Controller;

class QuotesController extends Controller
{
    // Show the quote form (if needed)

    public function create()
    {
        $this->view->layout('app'); // uses App/Views/layouts/app.php
        $this->view('quote');
    }

    // Handle quote form submission
    public function store()
    {
        // DEBUG: Output POST data for troubleshooting
        if (php_sapi_name() !== 'cli') {
            header('Content-Type: text/plain');
        }
        // var_dump($_POST);
        // die('Debugging POST data');
        error_log('QUOTE DEBUG POST: ' . print_r($_POST, true));
        if (empty($_POST)) {
            echo "No POST data received.\n";
            exit;
        }
        // Validate required fields
        $required = ['name', 'email', 'phone', 'delivery_address', 'product_type', 'quantity', 'timeline'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                echo "Missing required field: $field\n";
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

        echo "Quote saved.\n";
        exit;
    }
}
