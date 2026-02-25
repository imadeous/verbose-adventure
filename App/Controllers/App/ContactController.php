<?php

namespace App\Controllers\App;

use App\Models\Contact;
use Core\Controller;
use App\Helpers\Notifier;
use Exception;
// use CURLFile;

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
        flash('success', 'Your message has been sent!');
        $this->redirect('/contact');

        // Send Telegram notification
        try {

            $name    = trim($_POST['name'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');
            // $phone   = trim($_POST['phone'] ?? '');

            if (!$name || !$email || !$message) {
                throw new Exception("All fields are required.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address.");
            }

            $text  = "📩 New Contact Submission\n\n";
            $text .= "Name: " . htmlspecialchars($name) . "\n";
            $text .= "Email: " . htmlspecialchars($email) . "\n";
            // if ($phone) {
            //     $text .= "Phone: " . htmlspecialchars($phone) . "\n";
            // }
            $text .= "Message:\n" . htmlspecialchars($message);

            $notifier = new Notifier(
                "8684168309:AAFSXOK4Lz2f4ddMqeNnC7bxhTbFYlHhqS8",
                [742400987, 518941049, 7776430535]
            );


            $notifier->send($text);

            $status = "Message sent successfully.";
            Notifier::notify("SUCCESS", "Contact form submitted successfully by: " . $name);
            // flash('success', 'Your message has been sent!');
            $this->redirect('/contact');
        } catch (Exception $e) {
            $status = $e->getMessage();
            Notifier::notify("ERROR", "Contact form error: " . $status);
            flash('error', 'There was an error sending your message: ' . $status);
        }
    }
}
