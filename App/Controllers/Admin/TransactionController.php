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
    public function store()
    {
        $data = $_POST;
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/create');
            return;
        }

        // Validate and set default values
        $data['type'] = $data['type'] ?? 'expense'; // Default to 'expense'
        $data['category'] = $data['category'] ?? 'general'; // Default category
        $data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0.0; // Ensure amount is a float

        // Create the transaction
        $transaction = new Transaction($data);
        $newId = $transaction->save();
        // Manual debug output to logs/error_log_craftophile_shop at project root
        $logDir = __DIR__ . '/../../../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logFile = $logDir . '/error_log_craftophile_shop';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " Transaction save() returned ID: " . print_r($newId, true) . "\n", FILE_APPEND);
        file_put_contents($logFile, date('Y-m-d H:i:s') . " Transaction attributes after save: " . print_r($transaction->toArray(), true) . "\n", FILE_APPEND);
        if ($newId) {
            flash('success', 'Transaction created successfully. ID: ' . $newId);
            $this->redirect('/admin/transactions');
        } else {
            flash('error', 'Failed to create transaction. Please try again.');
            $this->redirect('/admin/transactions/create');
        }
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

    public function edit($id)
    {
        $this->view->layout('admin');
        $transaction = Transaction::find($id);
        if (!$transaction) {
            flash('error', 'Transaction not found.');
            $this->redirect('/admin/transactions');
            return;
        }
        $this->view('admin/transactions/edit', [
            'transaction' => $transaction,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Transactions', 'url' => url('/admin/transactions')],
                ['label' => 'Edit'],
            ],
        ]);
    }
    public function update($id)
    {
        $data = $_POST;
        $transaction = Transaction::find($id);
        if (!$transaction) {
            flash('error', 'Transaction not found.');
            $this->redirect('/admin/transactions');
            return;
        }

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/edit/' . $id);
            return;
        }

        // Update transaction data
        $transaction->fill($data);
        if ($transaction->update()) {
            flash('success', 'Transaction updated successfully.');
            $this->redirect('/admin/transactions');
        } else {
            flash('error', 'Failed to update transaction. Please try again.');
            $this->redirect('/admin/transactions/edit/' . $id);
        }
    }
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            flash('error', 'Transaction not found.');
            $this->redirect('/admin/transactions');
            return;
        }

        if ($transaction->delete()) {
            flash('success', 'Transaction deleted successfully.');
        } else {
            flash('error', 'Failed to delete transaction. Please try again.');
        }
        $this->redirect('/admin/transactions');
    }
}
