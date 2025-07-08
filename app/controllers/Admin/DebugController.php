<?php

namespace App\Controllers\Admin;

use App\Helpers\Breadcrumb;
use Core\Controller;

class DebugController extends Controller
{
    public function __construct()
    {
        // All methods in this controller will use the admin layout
        $this->setLayout('admin');
    }

    /**
     * Show the application debug information page.
     */
    public function index()
    {
        Breadcrumb::add([
            ['label' => 'Debug']
        ]);
        return $this->view('admin/debug');
    }
}
