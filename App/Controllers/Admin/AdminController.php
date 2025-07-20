<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;

class AdminController extends AdminControllerBase
{
    public function index()
    {
        // Set the layout for the admin dashboard
        $this->view->layout('admin'); // uses App/Views/layouts/admin.php
        // Render the view using section/yield system
        $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')]
            ]
        ]);
    }
}
