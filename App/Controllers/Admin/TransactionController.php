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
            $query->where('date', '>=', date('Y-01-01'))
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

        // Get total count for pagination - need to build query separately
        $countQuery = Transaction::query();

        // Reapply all filters for counting
        if (!empty($filters['date_from']) || !empty($filters['date_to'])) {
            if (!empty($filters['date_from'])) {
                $countQuery->where('date', '>=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $countQuery->where('date', '<=', $filters['date_to']);
            }
        } else {
            $countQuery->where('date', '>=', date('Y-m-01'))
                ->where('date', '<=', date('Y-m-t'));
        }

        if (!empty($filters['type'])) {
            $countQuery->where('type', '=', $filters['type']);
        }

        if (!empty($filters['category'])) {
            $categoryQuery = \App\Models\Category::query()
                ->where('name', 'LIKE', '%' . $filters['category'] . '%')
                ->get();
            if (!empty($categoryQuery)) {
                $categoryId = $categoryQuery[0]['id'];
                $countQuery->where('category_id', '=', $categoryId);
            } else {
                $countQuery->where('id', '=', -1);
            }
        }

        if ($filters['min_amount'] !== null) {
            $countQuery->where('amount', '>=', $filters['min_amount']);
        }
        if ($filters['max_amount'] !== null) {
            $countQuery->where('amount', '<=', $filters['max_amount']);
        }

        $totalTransactions = $countQuery->count()[0]['count'];
        $paginator = new Paginator($totalTransactions, $perPage, $page);

        // Get transactions with pagination
        $transactions = $query->orderBy('created_at', 'desc')
            ->limit($paginator->perPage)
            ->offset($paginator->offset())
            ->get();

        // Convert to Transaction objects
        $transactions = array_map(
            fn($row) => new Transaction($row),
            $transactions
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
        // Redirect to income page by default
        $this->redirect('/admin/transactions/income/create');
    }

    public function createIncome()
    {
        $categories = \App\Models\Category::all();
        $promo_codes = [];

        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')],
            ['label' => 'Add Income', 'url' => url('/admin/transactions/income/create')],
        ];
        $this->view('admin/transactions/create-income', [
            'categories' => $categories,
            'promo_codes' => $promo_codes,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function createExpense()
    {
        $categories = \App\Models\Category::all();

        $this->view->layout('admin');
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => url('/admin')],
            ['label' => 'Transactions', 'url' => url('/admin/transactions')],
            ['label' => 'Add Expense', 'url' => url('/admin/transactions/expense/create')],
        ];
        $this->view('admin/transactions/create-expense', [
            'categories' => $categories,
            'breadcrumb' => $breadcrumbs
        ]);
    }

    public function storeIncome()
    {
        $data = $_POST;

        // CSRF check
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/income/create');
            return;
        }

        // Set defaults and sanitize
        $data['type'] = 'income';
        $data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0.0;
        $data['created_at'] = date('Y-m-d H:i:s');

        // Handle quantity for stock subtraction (but don't save to transaction table)
        $quantity = isset($data['quantity']) ? intval($data['quantity']) : 0;

        // If variant_id and quantity are provided, subtract from stock
        if (!empty($data['variant_id']) && $quantity > 0) {
            $variant = \App\Models\Variant::find($data['variant_id']);
            if ($variant) {
                $newStock = $variant->stock_quantity - $quantity;
                if ($newStock < 0) {
                    flash('error', 'Insufficient stock. Available: ' . $variant->stock_quantity);
                    $this->redirect('/admin/transactions/income/create');
                    return;
                }
                $variant->stock_quantity = $newStock;
                $variant->update();
            }
        }

        // Remove quantity from data (it shouldn't be saved to transactions table)
        unset($data['quantity']);

        // Remove empty optional fields
        foreach (['quote_id', 'promo_code_id', 'date', 'description', 'category_id', 'product_id', 'variant_id'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                unset($data[$field]);
            }
        }

        // Create and save
        $transaction = new Transaction($data);
        $newId = $transaction->save();

        if ($newId) {
            flash('success', 'Income transaction created successfully. ID: ' . $newId);
            $this->redirect('/admin/transactions');
        } else {
            flash('error', 'Failed to create income transaction. Please try again.');
            $this->redirect('/admin/transactions/income/create');
        }
    }

    public function storeExpense()
    {
        $data = $_POST;

        // CSRF check
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/expense/create');
            return;
        }

        // Set defaults and sanitize
        $data['type'] = 'expense';
        $data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0.0;
        $data['created_at'] = date('Y-m-d H:i:s');

        // Remove empty optional fields
        foreach (['date', 'description', 'category_id'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                unset($data[$field]);
            }
        }

        // Create and save
        $transaction = new Transaction($data);
        $newId = $transaction->save();

        if ($newId) {
            flash('success', 'Expense transaction created successfully. ID: ' . $newId);
            $this->redirect('/admin/transactions');
        } else {
            flash('error', 'Failed to create expense transaction. Please try again.');
            $this->redirect('/admin/transactions/expense/create');
        }
    }

    public function store()
    {
        // Redirect to appropriate create page based on type
        $type = $_POST['type'] ?? 'expense';
        if ($type === 'income') {
            $this->redirect('/admin/transactions/income/create');
        } else {
            $this->redirect('/admin/transactions/expense/create');
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
            ['label' => 'Edit Transaction #' . $id, 'url' => url('/admin/transactions/' . $id . '/edit')]
        ];

        $this->view('admin/transactions/edit', [
            'transaction' => $transaction,
            'breadcrumb' => $breadcrumbs
        ]);
    }
    public function update($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            flash('error', 'Transaction not found.');
            $this->redirect('/admin/transactions');
            return;
        }

        $data = $_POST;

        // CSRF validation
        if (empty($data['_csrf']) || !\App\Helpers\Csrf::check($data['_csrf'])) {
            flash('error', 'Invalid or missing CSRF token. Please try again.');
            $this->redirect('/admin/transactions/' . $id . '/edit');
            return;
        }

        // Remove _csrf and _method fields if present
        unset($data['_csrf'], $data['_method']);

        // Update transaction data
        $transaction->fill($data);
        if ($transaction->update()) {
            flash('success', 'Transaction updated successfully.');
            $this->redirect('/admin/transactions');
        } else {
            flash('error', 'Failed to update transaction. Please try again.');
            $this->redirect('/admin/transactions/' . $id . '/edit');
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
