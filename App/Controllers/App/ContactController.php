<?php

namespace App\Controllers\App;

use App\Models\Contact;
use Core\Controller;

class ContactController extends Controller
{
    // Show the contact us page
    public function index()
    {
        $this->view->layout('app');
        $this->view('contact'); // expects App/Views/contact.view.php
    }

    // Handle contact form submission
    public function store()
    {

        // Debug: before CSRF check
        error_log('DEBUG: Before CSRF check');

        // CSRF validation
        if (empty($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
            error_log('DEBUG: CSRF check failed');
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/contact');
            return;
        }
        error_log('DEBUG: After CSRF check');

        $required = ['name', 'email', 'message'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                error_log('DEBUG: Missing required field: ' . $field);
                flash('error', "Missing required field: $field");
                $this->redirect('/contact');
                return;
            }
        }
        error_log('DEBUG: All required fields present');

        $contact = new Contact();
        $contact->fill([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'message' => $_POST['message'],
        ]);
        error_log('DEBUG: Before contact save');
        $contact->save();
        error_log('DEBUG: After contact save');

        flash('success', 'Your message has been sent!');
        $this->redirect('/contact');
    }
}
