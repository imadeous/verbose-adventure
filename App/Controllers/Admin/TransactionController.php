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

        // Get filter parameters
        $filters = [
            'date_from' => $_GET['date_from'] ?? null,
            'date_to' => $_GET['date_to'] ?? null,
            'type' => $_GET['type'] ?? null,
            'category' => $_GET['category'] ?? null,
            'min_amount' => isset($_GET['min_amount']) && is_numeric($_GET['min_amount']) ? (float)$_GET['min_amount'] : null,
            'max_amount' => isset($_GET['max_amount']) && is_numeric($_GET['max_amount']) ? (float)$_GET['max_amount'] : null,
        ];

        // Build the base query with filters
        $query = Transaction::query();

        // Apply date filters (default to current month if no filters provided)
        if (!empty($filters['date_from']) || !empty($filters['date_to'])) {
            if (!empty($filters['date_from'])) {
                $query->where('date', '>=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $query->where('date', '<=', $filters['date_to']);
            }
        } else {
            // Default to current month if no date filters
            $query->where('date', '>=', date('Y-m-01'))
                ->where('date', '<=', date('Y-m-t'));
        }

        // Apply type filter
        if (!empty($filters['type'])) {
            $query->where('type', '=', $filters['type']);
        }

        // Apply category filter (search in category name)
        if (!empty($filters['category'])) {
            // Get category IDs that match the search term
            $categoryQuery = \App\Models\Category::query()
                ->where('name', 'LIKE', '%' . $filters['category'] . '%')
                ->get();

            if (!empty($categoryQuery)) {
                // For simplicity, just use the first matching category
                // In a more advanced implementation, you could build a more complex query
                $categoryId = $categoryQuery[0]['id'];
                $query->where('category_id', '=', $categoryId);
            } else {
                // No matching categories found, return empty result
                $query->where('id', '=', -1); // Force no results
            }
        }

        // Apply amount range filters
        if ($filters['min_amount'] !== null) {
            $query->where('amount', '>=', $filters['min_amount']);
        }
        if ($filters['max_amount'] !== null) {
            $query->where('amount', '<=', $filters['max_amount']);
        }

        // Get total count for pagination
        $totalTransactions = $query->count()[0]['count'];
        $paginator = new Paginator($totalTransactions, $perPage, $page);

        // Get transactions with pagination
        $transactions = array_map(
            fn($row) => new Transaction($row),
            $query->orderBy('created_at', 'desc')
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
