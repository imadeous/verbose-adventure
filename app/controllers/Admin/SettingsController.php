<?php

namespace App\Controllers\Admin;

use App\Helpers\Breadcrumb;
use Core\Controller;
use App\Models\SiteAnalytics;
use App\Helpers\ManagedTables;
use Core\App;

class SettingsController extends Controller
{
    public function index()
    {
        Breadcrumb::add([
            ['label' => 'Settings']
        ]);
        $configPath = project_root('config/features/analytics.json');
        $config = [];
        if (file_exists($configPath)) {
            $config = json_decode(file_get_contents($configPath), true);
        }

        $db = \Core\App::get('database');
        $analyticsTableExists = !empty($db->raw("SHOW TABLES LIKE 'site_analytics'"));

        return $this->view('admin/settings/index', [
            'config' => $config,
            'analyticsTableExists' => $analyticsTableExists
        ], 'admin');
    }

    public function analytics()
    {
        Breadcrumb::add([
            ['label' => 'Settings', 'url' => 'admin/settings'],
            ['label' => 'Site Analytics']
        ]);

        // Date filter logic
        $start = $_GET['start'] ?? null;
        $end = $_GET['end'] ?? null;
        $query = SiteAnalytics::query();
        if ($start) {
            $query->where('visit_timestamp', '>=', $start . ' 00:00:00');
        }
        if ($end) {
            $query->where('visit_timestamp', '<=', $end . ' 23:59:59');
        }
        $data = $query->get();

        // Unique visitors (by IP)
        $uniqueVisitors = count(array_unique(array_map(fn($row) => $row->visitor_ip, $data)));

        // Chart data preparation
        $chartData = [];
        foreach ($data as $row) {
            $date = date('Y-m-d', strtotime($row->visit_timestamp));
            if (!isset($chartData[$date])) {
                $chartData[$date] = 0;
            }
            $chartData[$date]++;
        }
        $chartData = array_map(fn($date, $count) => ['date' => $date, 'visits' => $count], array_keys($chartData), $chartData);

        return $this->view('admin/settings/analytics', [
            'data' => $data,
            'uniqueVisitors' => $uniqueVisitors,
            'start' => $start,
            'end' => $end,
            'chartData' => $chartData
        ], 'admin');
    }

    public function updateAnalytics()
    {
        if (!\Core\Csrf::verify(\Core\Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            redirect('admin/settings');
            return;
        }

        $enabled = \Core\Request::post('analytics_enabled') === 'on';
        $trackedData = \Core\Request::post('tracked_data') ?? [];

        $config = [
            'enabled' => $enabled,
            'tracked_data' => $trackedData,
            'installed' => file_exists(project_root('config/features/analytics.json')) ? (json_decode(file_get_contents(project_root('config/features/analytics.json')), true)['installed'] ?? false) : false
        ];

        if ($enabled && !$config['installed']) {
            if ($this->installAnalyticsFeature()) {
                $config['installed'] = true;
                session()->flash('success', 'Site analytics feature installed successfully!');
            } else {
                $config['enabled'] = false; // Don't enable if installation fails
                session()->flash('error', 'Failed to install site analytics feature. The table might already exist.');
            }
        }

        $configPath = project_root('config/features/analytics.json');
        file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT));

        if (!session()->has('error')) {
            session()->flash('success', 'Analytics settings updated successfully.');
        }

        redirect('admin/settings');
    }

    public function updateManagedTables()
    {
        if (!\Core\Csrf::verify(\Core\Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            redirect('admin/settings');
            return;
        }

        $selectedTables = \Core\Request::post('managed_tables', []);

        try {
            if (ManagedTables::updateManagedTables($selectedTables)) {
                session()->flash('success', 'Managed tables updated successfully.');
            } else {
                session()->flash('error', 'Failed to write to managed tables file. Check permissions.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating managed tables: ' . $e->getMessage());
        }

        redirect('admin/settings');
    }

    private function installAnalyticsFeature()
    {
        try {
            $db = App::get('database');
            $sql = "CREATE TABLE `site_analytics` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `page_url` varchar(255) NOT NULL,
                `ip_address` varchar(45) NOT NULL,
                `user_agent` text NOT NULL,
                `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
            $db->raw($sql);
            return true;
        } catch (\Exception $e) {
            // Likely the table already exists, log or handle as needed
            return false;
        }
    }

    public function getManagedTablesJson()
    {
        header('Content-Type: application/json');
        echo ManagedTables::getJson();
        exit;
    }
}
