<?php

namespace App\Controllers\App;

use App\Models\Contact;
use Core\Controller;
use App\Helpers\Notifier;
use Exception;

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
            'message' => $_POST['message'],
        ]);
        $contact->save();

        // Send Telegram notification
        try {

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!$name || !$email || !$message) {
                throw new Exception("All fields are required.");
            }

            $text = "Name: " . htmlspecialchars($name) . "\n";
            $text .= "Email: " . htmlspecialchars($email) . "\n";

            $text .= "Message:\n" . htmlspecialchars($message);

            $notifier = new Notifier(
                getenv('TELEGRAM_BOT_TOKEN'),
                explode(',', getenv('TELEGRAM_CHAT_IDS'))
            );


            $notifier::notify(
                "📩 New Contact Form Submission",
                $text
            );


            $status = "Message sent successfully.";
        } catch (Exception $e) {
            $status = $e->getMessage();
        }

        flash('success', 'Your message has been sent!');
        $this->redirect('/contact');
    }
}
