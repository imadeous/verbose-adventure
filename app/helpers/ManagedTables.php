<?php

namespace App\Helpers;

use Core\App;

class ManagedTables
{
    private static $filePath;

    public static function initialize()
    {
        self::$filePath = project_root() . '/config/managed_tables.json';
    }

    private static function getFilePath()
    {
        return self::$filePath;
    }

    /**
     * Returns a list of table names that are managed.
     *
     * @return array
     */
    public static function getNames(): array
    {
        self::initialize();
        if (!file_exists(self::getFilePath())) {
            return [];
        }
        $json = file_get_contents(self::getFilePath());
        return json_decode($json, true) ?? [];
    }

    /**
     * Returns a list of all tables in the database.
     *
     * @return array
     */
    public static function getAllTables(): array
    {
        $db = App::get('database');
        try {
            return $db->raw("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\Exception $e) {
            // Handle exception, maybe log it
            return [];
        }
    }

    /**
     * Updates the list of managed tables.
     *
     * @param array $tables
     * @return bool
     */
    public static function updateManagedTables(array $tables): bool
    {
        self::initialize();
        $json = json_encode(array_values($tables), JSON_PRETTY_PRINT);
        return file_put_contents(self::getFilePath(), $json) !== false;
    }

    /**
     * Returns a JSON response with all tables and managed tables.
     *
     * @return string
     */
    public static function getJson(): string
    {
        $allTables = self::getAllTables();
        $managedTables = self::getNames();

        return json_encode([
            'all_tables' => $allTables,
            'managed_tables' => $managedTables
        ]);
    }
}
