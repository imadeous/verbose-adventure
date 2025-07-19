<?php

namespace App\Controllers\App;

use App\Models\Contact;
use Core\Controller;

class ContactController extends Controller
{
    // Show the contact us page
    public function create()
    {
        $this->view->layout('app');
        $this->view('contact'); // expects App/Views/contact.view.php
    }

    // Handle contact form submission
    public function store()
    {

        // CSRF validation
        if (empty($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/contact');
            return;
        }

        $required = ['name', 'email', 'message'];
        foreach ($required as $field) {
            if (empty($_POST[$field]) || (is_string($_POST[$field]) && trim($_POST[$field]) === '')) {
                flash('error', "Missing required field: $field");
                $this->redirect('/contact');
                return;
            }
        }

        $contact = new Contact();
        $contact->fill([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'message' => $_POST['message'],
        ]);
        $contact->save();

        flash('success', 'Your message has been sent!');
        $this->redirect('/contact');
    }
}
