<?php

namespace App\Controllers\Admin;

use App\Helpers\Paginator;
use App\Models\Transaction;
use Core\AdminControllerBase;
use Core\Database\ReportBuilder;

class TransactionController extends AdminControllerBase
{
    public function index()
    {
        // Validate and sanitize pagination parameters
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['limit']) && is_numeric($_GET['limit']) && (int)$_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;

        $totalTransactions = Transaction::query()
            ->where('date', '>=', date('Y-m-01'))
            ->where('date', '<=', date('Y-m-t'))
            ->count()[0]['count'];

        $paginator = new Paginator($totalTransactions, $perPage, $page);

        $transactions = array_map(
            fn($row) => new Transaction($row),
            Transaction::query()
                ->where('date', '>=', date('Y-m-01'))
                ->where('date', '<=', date('Y-m-t'))
                ->orderBy('created_at', 'desc')
                ->limit($paginator->perPage)
                ->offset($paginator->offset())
                ->get()
        );

        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')]
        ];
        $this->view('admin/transactions/index', [
            'paginator' => $paginator,
            'transactions' => $transactions,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $quotes = \App\Models\Quote::all();
        $promo_codes = [];

        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')],
            ['label' => 'Create', 'url' => url('/admin/transactions/create')],
        ];
        $this->view('admin/transactions/create', [
            'categories' => $categories,
            'quotes' => $quotes,
            'promo_codes' => $promo_codes,
            'breadcrumb' => $breadcrumbs
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
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')],
            ['label' => 'Transaction #' . $id, 'url' => url('/admin/transactions/' . $id)]
        ];
        $this->view('admin/transactions/show', [
            'transaction' => $transaction,
            'breadcrumb' => $breadcrumbs
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
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')],
            ['label' => 'Edit Transaction #' . $id, 'url' => url('/admin/transactions/edit/' . $id)]
        ];
        $this->view('admin/transactions/edit', [
            'transaction' => $transaction,
            'breadcrumb' => $breadcrumbs
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
