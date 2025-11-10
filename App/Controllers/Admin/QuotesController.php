<?php

namespace App\Controllers\Admin;

use App\Models\Quote;
use Core\AdminControllerBase;

class QuotesController extends AdminControllerBase
{
    public function index()
    {
        $quotes = Quote::all();
        $this->view->layout('admin');
        $this->view('admin/quotes/index', [
            'quotes' => $quotes,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Quotes'],
            ],
        ]);
    }

    public function show($id)
    {
        $quote = Quote::find($id);
        $this->view->layout('admin');
        $this->view('admin/quotes/show', [
            'quote' => $quote,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Quotes', 'url' => url('/admin/quotes')],
                ['label' => $quote ? $quote->name : 'Quote'],
            ],
        ]);
    }

    public function destroy($id)
    {
        $quote = Quote::find($id);
        if ($quote) {
            $quote->delete();
        }
        header('Location: ' . url('admin/quotes'));
        exit;
    }

    public function bulkAction()
    {
        $action = $_POST['action'] ?? '';
        $quoteIds = $_POST['quote_ids'] ?? '';

        if (empty($action) || empty($quoteIds)) {
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $ids = array_filter(array_map('intval', explode(',', $quoteIds)));

        if (empty($ids)) {
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        switch ($action) {
            case 'delete':
                $this->bulkDelete($ids);
                break;
            case 'mark_read':
                $this->bulkMarkAsRead($ids);
                break;
        }

        header('Location: ' . url('admin/quotes'));
        exit;
    }

    private function bulkDelete($ids)
    {
        foreach ($ids as $id) {
            $quote = Quote::find($id);
            if ($quote) {
                $quote->delete();
            }
        }

        // Set success message
        $_SESSION['flash_message'] = 'Selected quotes have been deleted successfully.';
        $_SESSION['flash_type'] = 'success';
    }

    private function bulkMarkAsRead($ids)
    {
        foreach ($ids as $id) {
            $quote = Quote::find($id);
            if ($quote) {
                // Assuming there's a 'read_at' or 'status' field to mark as read
                // Update this based on your actual Quote model structure
                $quote->update(['status' => 'read']);
            }
        }

        // Set success message
        $_SESSION['flash_message'] = 'Selected quotes have been marked as read.';
        $_SESSION['flash_type'] = 'success';
    }
}
