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
}
