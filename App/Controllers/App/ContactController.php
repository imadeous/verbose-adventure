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
        echo 'DEBUG: Before CSRF check<br>';

        // CSRF validation
        if (empty($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
            echo 'DEBUG: CSRF check failed<br>';
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/contact');
            return;
        }
        echo 'DEBUG: After CSRF check<br>';

        $required = ['name', 'email', 'message'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                echo 'DEBUG: Missing required field: ' . $field . '<br>';
                flash('error', "Missing required field: $field");
                $this->redirect('/contact');
                return;
            }
        }
        echo 'DEBUG: All required fields present<br>';

        $contact = new Contact();
        $contact->fill([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'message' => $_POST['message'],
        ]);
        echo 'DEBUG: Before contact save<br>';
        $contact->save();
        echo 'DEBUG: After contact save<br>';

        flash('success', 'Your message has been sent!');
        $this->redirect('/contact');
    }
}
