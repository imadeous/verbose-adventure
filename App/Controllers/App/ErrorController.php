<?php

namespace App\Controller;

namespace App\Controllers\App;

use Core\Controller;

class ErrorController extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        $this->view->layout('app'); // uses App/Views/layouts/app.php
        $this->view('404', [
            'title' => 'Page Not Found',
            'message' => 'The page you are looking for does not exist.'
        ]);
        exit;
    }

    public function viewNotFound($viewName = '')
    {
        http_response_code(500);
        $this->view->layout('app');
        $message = 'The requested view file';
        if ($viewName) {
            $message .= " '<strong>" . htmlspecialchars($viewName) . "</strong>'";
        }
        $message .= ' could not be found.';
        if (method_exists($this, 'view')) {
            $this->view('404', [
                'title' => 'View Not Found',
                'message' => $message
            ]);
        } else {
            echo '<h1>View Not Found</h1><p>' . $message . '</p>';
        }
        exit;
    }
}
