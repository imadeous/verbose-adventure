<?php

namespace App\Controllers\Admin;

use App\Helpers\Breadcrumb;
use App\Helpers\ManagedTables;
use Core\App;
use Core\Controller;
use Core\Database\Connection;
use Core\Database\QueryBuilder;
use Core\Request;
use Core\Csrf;
use Exception;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        Breadcrumb::add([
            ['label' => 'Tables']
        ]);
        try {
            $config = App::get('config')['database'];
            $dbName = $config['name'];
            $pdo = Connection::make($config);
            $db = new QueryBuilder($pdo);

            $sql = "SELECT 
                        TABLE_NAME as name, 
                        ENGINE as engine, 
                        TABLE_ROWS as row_count, 
                        (DATA_LENGTH + INDEX_LENGTH) as size_bytes, 
                        CREATE_TIME as created_at
                    FROM 
                        information_schema.TABLES 
                    WHERE 
                        TABLE_SCHEMA = ? 
                    ORDER BY 
                        TABLE_NAME";

            $tables = $db->raw($sql, [$dbName])->fetchAll(\PDO::FETCH_OBJ);

            // Define which tables have a dedicated admin resource view
            $managedTables = ManagedTables::getNames();
            $csrfToken = Csrf::generate(); // Generate token once

            return $this->view('admin/tables/index', [
                'tables' => $tables,
                'managedTables' => $managedTables,
                'csrf_token' => $csrfToken // Pass token to view
            ], 'admin');
        } catch (Exception $e) {
            session()->flash('error', 'Could not fetch tables: ' . $e->getMessage());
            return redirect(url('admin'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        Breadcrumb::add([
            ['label' => 'Tables', 'url' => 'admin/tables'],
            ['label' => 'Create']
        ]);
        return $this->view('admin/tables/create', [], 'admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store()
    {
        $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', Request::input('table_name'));
        $columns = Request::input('columns', []);
        $primaryKeyIndex = Request::input('primary_key');
        $timestamps = Request::input('timestamps', []); // This will be an array of checked values

        if (empty($tableName)) {
            session()->flash('error', 'Table name is required.');
            return redirect('/admin/tables/create');
        }

        $sql = "CREATE TABLE IF NOT EXISTS `{$tableName}` (";
        $columnParts = [];
        $primaryKey = null;

        foreach ($columns as $index => $col) {
            if (empty($col['name'])) continue;

            $part = "`{$col['name']}` {$col['type']}";
            if (!empty($col['length'])) {
                $part .= "({$col['length']})";
            }

            if (isset($col['nullable'])) {
                $part .= " NULL";
            } else {
                $part .= " NOT NULL";
            }

            if (isset($col['auto_increment'])) {
                $part .= " AUTO_INCREMENT";
            }

            $columnParts[] = $part;

            if (isset($primaryKeyIndex) && $index == $primaryKeyIndex) {
                $primaryKey = $col['name'];
            }
        }

        // Add created_at and updated_at if either is checked
        if (!empty($timestamps)) {
            if (in_array('created_at', $timestamps)) {
                $columnParts[] = "`created_at` timestamp NULL DEFAULT NULL";
            }
            if (in_array('updated_at', $timestamps)) {
                $columnParts[] = "`updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()";
            }
        }

        $sql .= implode(', ', $columnParts);

        if ($primaryKey) {
            $sql .= ", PRIMARY KEY (`{$primaryKey}`)";
        }

        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        try {
            $db = App::get('database');
            $db->raw($sql);
            session()->flash('success', "Table '{$tableName}' created successfully.");
            redirect(url('admin/tables'));
        } catch (Exception $e) {
            session()->flash('error', "Error creating table: " . $e->getMessage());
            redirect(url('admin/tables/create'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return void
     */
    public function show($name)
    {
        try {
            $db = App::get('database');
            $tableData = $db->selectAll($name);
            $columns = !empty($tableData) ? array_keys((array) $tableData[0]) : [];

            Breadcrumb::add([
                ['label' => 'Tables', 'url' => 'admin/tables'],
                ['label' => $name]
            ]);

            return $this->view('admin/tables/show', [
                'tableName' => $name,
                'columns' => $columns,
                'tableData' => $tableData
            ], 'admin');
        } catch (Exception $e) {
            session()->flash('error', 'Could not fetch table data: ' . $e->getMessage());
            return redirect(url('admin/tables'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return void
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return void
     */
    public function destroy($name)
    {
        if (!Csrf::verify(Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            return redirect(url('admin/tables'));
        }

        try {
            $db = App::get('database');
            $db->raw("DROP TABLE IF EXISTS `{$name}`");
            session()->flash('success', "Table '{$name}' deleted successfully.");
        } catch (Exception $e) {
            session()->flash('error', "Error deleting table: " . $e->getMessage());
        }

        redirect(url('admin/tables'));
    }

    /**
     * Truncate the specified table.
     *
     * @param  string  $name
     * @return void
     */
    public function truncate($name)
    {
        if (!Csrf::verify(Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            return redirect(url('admin/tables/' . $name));
        }

        try {
            $db = App::get('database');
            $db->raw("TRUNCATE TABLE `{$name}`");
            session()->flash('success', "Table '{$name}' truncated successfully.");
        } catch (Exception $e) {
            session()->flash('error', "Error truncating table: " . $e->getMessage());
        }

        redirect(url('admin/tables/' . $name));
    }

    /**
     * Manage table visibility in the admin sidebar.
     *
     * @return void
     */
    public function manage()
    {
        if (!Csrf::verify(Request::post('_token'))) {
            session()->flash('error', 'Invalid CSRF token.');
            return redirect(url('admin/tables'));
        }

        $managedTables = Request::post('managed_tables', []);
        ManagedTables::updateManagedTables($managedTables);

        session()->flash('success', 'Managed tables updated successfully.');
        redirect(url('admin/tables'));
    }
}
