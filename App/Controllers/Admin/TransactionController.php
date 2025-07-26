<?php

namespace App\Controllers\Admin;

use App\Models\Transaction;
use Core\AdminControllerBase;
use Core\Database\ReportBuilder;

class TransactionController extends AdminControllerBase
{
    public function index()
    {
        $transactions = array_map(
            fn($row) => new Transaction($row),
            Transaction::query()
                ->where('date', '>=', date('Y-m-01')) // Filter for current month
                ->where('date', '<=', date('Y-m-t')) // Filter for current month
                ->orderBy('created_at', 'desc')
                ->get()
        );

        $dailyReport = ReportBuilder::build('transactions', 'date')
            ->forPeriod(date('Y-m-01'), date('Y-m-t')) // Aggregate for current month
            ->daily()
            // ->withEmptyNodes(true)
            ->withSum('amount', 'Total')
            ->withMax('amount', 'Max')
            ->withMin('amount', 'Min')
            ->withAverage('amount', 'Average')
            ->withCount('*', 'Count')
            ->generate('Daily Transactions Report', true);

        $this->view->layout('admin');
        $this->view('admin/transactions/index', [
            'transactions' => $transactions,
            'dailyReport' => $dailyReport,
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

    public function bulkStore($n = null)
    {
        // Accept n from POST if not provided
        if ($n === null) {
            $n = isset($_POST['n']) ? (int)$_POST['n'] : 10;
        }
        $categories = [1, 2, 3, 4, 5]; // Example category IDs
        $types = ['income', 'expense'];
        $descriptions = ['Salary', 'Rent', 'Sale', 'Purchase', 'Refund', 'Bonus', 'Commission', 'Fee', 'Gift', 'Other'];
        $count = 0;
        for ($i = 0; $i < $n; $i++) {
            $type = $types[array_rand($types)];
            $amount = $type === 'income'
                ? rand(1000, 20000) + rand(0, 99) / 100
                : -1 * (rand(100, 18000) + rand(0, 99) / 100);
            $category_id = $categories[array_rand($categories)];
            $description = $descriptions[array_rand($descriptions)];
            $date = date('Y-m-d', rand(strtotime('2020-01-01'), strtotime('2025-07-31')));
            $created_at = date('Y-m-d H:i:s', strtotime($date) + rand(0, 86400));
            $data = [
                'type' => $type,
                'amount' => $amount,
                'category_id' => $category_id,
                'description' => $description,
                'date' => $date,
                'created_at' => $created_at,
            ];
            $transaction = new \App\Models\Transaction($data);
            if ($transaction->save()) {
                $count++;
            }
        }
        flash('success', "Bulk created $count random transactions.");
        $this->redirect('/admin/transactions');
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
