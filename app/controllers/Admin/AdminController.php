<?php

namespace App\Controllers\Admin;

use App\Helpers\Breadcrumb;
use Core\Controller;

class AdminController extends Controller
{
    public function index()
    {
        Breadcrumb::add([
            ['label' => 'Dashboard']
        ]);
        return $this->view('admin/index', [], 'admin');
    }
}
