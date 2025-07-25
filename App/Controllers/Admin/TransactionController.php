<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\Transaction;

class TransactionController extends AdminController
{
    public function index()
    {
        $transactions = Transaction::query()
            ->orderBy('created_at', 'desc')
            ->get();
        $this->view->layout('admin');
        $this->view('admin/transactions/index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/transactions/create', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Transactions', 'url' => url('/admin/transactions')],
                ['label' => 'Create'],
            ],
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $transaction = Transaction::find($id);
        if (!$transaction) {
            flash('error', 'Transaction not found.');
            $this->redirect('/admin/transactions');
            return;
        }
        $this->view('admin/transactions/show', [
            'transaction' => $transaction
        ]);
    }

    // Add create, store, edit, update, destroy as needed
}
