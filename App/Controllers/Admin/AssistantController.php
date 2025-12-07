<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;

class AssistantController extends AdminController
{
    public function index()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/index', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant']
            ]
        ]);
    }
}
