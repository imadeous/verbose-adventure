<?php

namespace App\Controllers\App;

use Core\Controller;

class ErrorController extends Controller
{
    /**
     * Handle 404 Not Found errors.
     */
    public function notFound()
    {
        http_response_code(404);
        return $this->view('404');
    }
}
