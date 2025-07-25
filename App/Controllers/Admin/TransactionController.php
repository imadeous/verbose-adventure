<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\Transaction;
use Core\Database\ReportBuilder;

class TransactionController extends AdminController
{
    public function index()
    {
        $transactions = array_map(
            fn($row) => new Transaction($row),
            Transaction::query()
                ->orderBy('created_at', 'desc')
                ->get()
        );

        // Test ReportBuilder forPeriod method
        $report = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-t')) // Aggregate for the current month
            ->monthly()
            ->withSum('amount', 'Total')
            ->withMax('amount', 'Max Amount')
            ->withMin('amount', 'Min Amount')
            ->withAverage('amount', 'Average')
            ->withCount('*', 'Total Transactions')
            ->generate('My Report Title');

        $this->view->layout('admin');
        $this->view('admin/transactions/index', [
            'transactions' => $transactions,
            'report' => $report,
        ]);
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $quotes = \App\Models\Quote::all();
        $promo_codes = [];

        $this->view->layout('admin');
        $this->view('admin/transactions/create', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Transactions', 'url' => url('/admin/transactions')],
                ['label' => 'Create'],
            ],
            'categories' => $categories,
            'quotes' => $quotes,
            'promo_codes' => $promo_codes,
        ]);
    }
    public function store()
    {
        $data = $_POST;

        // CSRF check
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/create');
            return;
        }

        // Set defaults and sanitize
        $data['type'] = isset($data['type']) && $data['type'] ? $data['type'] : 'expense';
        $data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0.0;
        $data['created_at'] = date('Y-m-d H:i:s');

        // Remove empty optional fields
        foreach (['quote_id', 'promo_code_id', 'date', 'description', 'category_id'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                unset($data[$field]);
            }
        }

        // Create and save
        $transaction = new Transaction($data);
        $newId = $transaction->save();

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
