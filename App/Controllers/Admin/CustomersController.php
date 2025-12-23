<?php

namespace App\Controllers\Admin;

use Core\AdminControllerBase;
use App\Models\Transaction;

class CustomersController extends AdminControllerBase
{
    public function index()
    {
        // Get customer statistics
        $stats = $this->getCustomerStats();

        // Get all customers with their metrics
        $customers = $this->getCustomersWithMetrics();

        $this->view->layout('admin');
        $this->view('admin/customers/index', [
            'stats' => $stats,
            'customers' => $customers,
            'title' => 'Customer Statistics'
        ]);
    }

    private function getCustomerStats()
    {
        // Unique customers count (where customer_username is not null)
        $uniqueCustomers = Transaction::query()
            ->selectRaw('COUNT(DISTINCT customer_username) as count')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->get();

        // Repeat customers - get all customers with their order counts, then count those with > 1 order
        $customerOrderCounts = Transaction::query()
            ->selectRaw('customer_username, COUNT(*) as order_count')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->where('type', '=', 'income')
            ->groupBy('customer_username')
            ->having('order_count', '>', 1)
            ->get();

        $repeatCustomersCount = count($customerOrderCounts);

        // Biggest spender
        $biggestSpender = Transaction::query()
            ->selectRaw('customer_username, SUM(amount) as total_spent')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->where('type', '=', 'income')
            ->groupBy('customer_username')
            ->orderBy('total_spent', 'DESC')
            ->limit(1)
            ->get();

        // Top platform
        $topPlatform = Transaction::query()
            ->selectRaw('platform, COUNT(*) as order_count')
            ->whereNotNull('platform')
            ->where('platform', '!=', '')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->where('type', '=', 'income')
            ->groupBy('platform')
            ->orderBy('order_count', 'DESC')
            ->limit(1)
            ->get();

        return [
            'unique_customers' => $uniqueCustomers[0]['count'] ?? 0,
            'repeat_customers' => $repeatCustomersCount,
            'biggest_spender' => !empty($biggestSpender) ? [
                'username' => $biggestSpender[0]['customer_username'],
                'total' => $biggestSpender[0]['total_spent']
            ] : null,
            'top_platform' => !empty($topPlatform) ? [
                'name' => $topPlatform[0]['platform'],
                'count' => $topPlatform[0]['order_count']
            ] : null
        ];
    }

    private function getCustomersWithMetrics()
    {
        // Get all customers with their metrics
        $customers = Transaction::query()
            ->selectRaw('customer_username, platform, COUNT(*) as orders_count, SUM(amount) as total_spent, MIN(date) as first_order_date, MAX(date) as last_order_date')
            ->whereNotNull('customer_username')
            ->where('customer_username', '!=', '')
            ->where('type', '=', 'income')
            ->groupBy(['customer_username', 'platform'])
            ->orderBy('total_spent', 'DESC')
            ->get();

        return $customers;
    }
}
