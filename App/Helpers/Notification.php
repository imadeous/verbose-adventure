<?php

namespace App\Helpers;

class Notification
{
    protected static $logFile = __DIR__ . '/../../public/storage/logs/notifications.json';

    /**
     * Log a change notification to the JSON log file.
     *
     * @param string $type The type of change (e.g., 'created', 'updated', 'deleted')
     * @param string $model The model/entity affected (e.g., 'Product', 'Category')
     * @param int|string|null $id The ID of the affected entity
     * @param array $data Additional data to log (optional)
     * @return void
     */
    public static function log($type, $model, $id = null, array $data = [])
    {
        $entry = [
            'timestamp' => date('c'),
            'type'      => $type,
            'model'     => $model,
            'id'        => $id,
            'data'      => $data,
            'user'      => isset($_SESSION['user']) ? $_SESSION['user'] : null
        ];

        $log = [];
        if (file_exists(self::$logFile)) {
            $content = file_get_contents(self::$logFile);
            $log = json_decode($content, true) ?: [];
        }
        $log[] = $entry;
        file_put_contents(self::$logFile, json_encode($log, JSON_PRETTY_PRINT));
    }

    /**
     * Load all notifications from the JSON log file.
     *
     * @return array
     */
    public static function all()
    {
        if (!file_exists(self::$logFile)) {
            return [];
        }
        $content = file_get_contents(self::$logFile);
        $log = json_decode($content, true);
        return is_array($log) ? $log : [];
    }

    /**
     * Get a single notification by its index (0 = oldest, -1 = latest).
     *
     * @param int $index
     * @return array|null
     */
    public static function get($index)
    {
        $all = self::all();
        if (empty($all)) {
            return null;
        }
        // Support negative index for latest
        if ($index < 0) {
            $index = count($all) + $index;
        }
        return isset($all[$index]) ? $all[$index] : null;
    }

    /**
     * Remove (drop) notifications by index or array of indexes from the JSON log file.
     *
     * @param int|array $indexes Index or array of indexes to remove (0 = oldest, -1 = latest)
     * @return void
     */
    public static function drop($indexes)
    {
        $log = self::all();
        if (empty($log)) {
            return;
        }
        if (!is_array($indexes)) {
            $indexes = [$indexes];
        }
        // Normalize negative indexes
        $count = count($log);
        $normalized = [];
        foreach ($indexes as $i) {
            $normalized[] = $i < 0 ? $count + $i : $i;
        }
        // Remove duplicates and sort descending to avoid shifting
        $normalized = array_unique($normalized);
        rsort($normalized);
        foreach ($normalized as $i) {
            if (isset($log[$i])) {
                array_splice($log, $i, 1);
            }
        }
        file_put_contents(self::$logFile, json_encode($log, JSON_PRETTY_PRINT));
    }
}

// use App\Helpers\Notification;

// // Log a new notification
// Notification::log('created', 'Product', 123, ['name' => 'Widget']);

// // Get all notifications
// $all = Notification::all();

// // Get the latest notification
// $latest = Notification::get(-1);

// // Drop the first and latest notifications
// Notification::drop([0, -1]);