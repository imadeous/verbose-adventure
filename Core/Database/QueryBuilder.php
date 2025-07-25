<?php

namespace Core\Database;

use Core\Database\Db;
use PDO;

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $columns = ['*'];
    protected $bindings = [];
    protected $wheres = [];
    protected $orWheres = [];
    protected $whereNulls = [];
    protected $not = false;
    protected $orderBy = '';
    protected $limit;
    protected $offset;
    protected $groupBy = [];
    protected $having = [];
    protected $joins = [];
    protected $aliases = [];
    protected $operation = 'select';
    protected $insertData = [];
    protected $updateData = [];
    protected $groupResultsBy = null;

    public function __construct($table)
    {
        $this->pdo = Db::instance();
        $this->table = $table;
    }

    public static function table($table)
    {
        return new static($table);
    }

    public static function select($columns = ['*'], $table = null)
    {
        $instance = new static($table);
        $instance->columns = $columns;
        $instance->operation = 'select';
        return $instance;
    }

    public function alias($original, $as)
    {
        $this->aliases[$original] = $as;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->wheres[] = [$column, $operator, $value, $this->not];
        $this->not = false;
        return $this;
    }

    public function andWhere($column, $operator, $value)
    {
        return $this->where($column, $operator, $value);
    }

    public function orWhere($column, $operator, $value)
    {
        $this->orWheres[] = [$column, $operator, $value];
        return $this;
    }

    public function whereNull($column)
    {
        $this->whereNulls[] = [$column, $this->not];
        $this->not = false;
        return $this;
    }

    public function whereNotNull(string $column, string $boolean = 'AND'): static
    {
        $this->wheres[] = [
            'type'    => 'Basic',
            'column'  => $column,
            'operator' => 'IS NOT NULL',
            'value'   => null,
            'boolean' => strtoupper($boolean),
        ];
        return $this;
    }

    public function not()
    {
        $this->not = true;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = (int)$limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = (int)$offset;
        return $this;
    }

    public function groupBy(...$columns)
    {
        // Flatten any nested arrays and merge
        foreach ($columns as $col) {
            if (is_array($col)) {
                $this->groupBy = array_merge($this->groupBy, $col);
            } else {
                $this->groupBy[] = $col;
            }
        }
        return $this;
    }


    /**
     * Group the result set into arrays by a column after fetching.
     * @param string $column
     * @return $this
     */
    public function groupResultsBy(string $column)
    {
        $this->groupResultsBy = $column;
        return $this;
    }

    public function groupByRef($column)
    {
        return $this->groupBy($column);
    }

    public function having($column, $operator, $value)
    {
        $this->having[] = [$column, $operator, $value];
        return $this;
    }

    public function join($table, $col1, $operator, $col2, $type = 'INNER')
    {
        $this->joins[] = "$type JOIN $table ON $col1 $operator $col2";
        return $this;
    }

    public function leftJoin($table, $col1, $operator, $col2)
    {
        return $this->join($table, $col1, $operator, $col2, 'LEFT');
    }

    public function rightJoin($table, $col1, $operator, $col2)
    {
        return $this->join($table, $col1, $operator, $col2, 'RIGHT');
    }

    public function insert(array $data)
    {
        $this->operation = 'insert';
        $this->insertData = $data;
        return $this->executeInsert();
    }

    public function update(array $data, $id, $primaryKey = 'id')
    {
        $this->operation = 'update';
        $this->updateData = $data;
        // Add WHERE clause for primary key
        $this->wheres = [[$primaryKey, '=', $id, false]];
        return $this->executeUpdate();
    }

    public function delete($id = null, $primaryKey = 'id')
    {
        $this->operation = 'delete';
        // Add WHERE clause for primary key if id is provided
        if ($id !== null) {
            $this->wheres = [[$primaryKey, '=', $id, false]];
        }
        return $this->executeDelete();
    }

    public function count($column = '*')
    {
        $this->columns = ["COUNT($column) as count"];
        return $this->get();
    }

    public function sum($column)
    {
        $this->columns = ["SUM($column) as sum"];
        return $this->get();
    }

    public function avg($column)
    {
        $this->columns = ["AVG($column) as avg"];
        return $this->get();
    }

    public function max($column)
    {
        $this->columns = ["MAX($column) as max"];
        return $this->get();
    }

    public function min($column)
    {
        $this->columns = ["MIN($column) as min"];
        return $this->get();
    }

    public function get()
    {
        $sql = $this->buildSql();
        // Debug output
        var_dump('SQL:', $sql, 'Bindings:', $this->bindings);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($this->groupResultsBy) {
            $grouped = [];
            foreach ($results as $row) {
                $grouped[$row[$this->groupResultsBy]][] = $row;
            }
            return $grouped;
        }
        return $results;
    }

    public function find($id, $primaryKey = 'id')
    {
        if (!$this->table) {
            throw new \Exception("No table set for QueryBuilder. Use table() or pass table to constructor.");
        }
        $sql = "SELECT * FROM {$this->table} WHERE {$primaryKey} = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function first()
    {
        $this->limit = 1;
        $results = $this->get();
        return $results[0] ?? null;
    }

    public function toSql()
    {
        return $this->buildSql();
    }

    protected function buildSql()
    {
        $sql = '';

        if (empty($this->table)) {
            // Fallback: try to use the first join table if available, else fail gracefully
            if (!empty($this->joins)) {
                // Extract table name from first join
                preg_match('/JOIN\s+(\w+)/i', $this->joins[0], $matches);
                $this->table = $matches[1] ?? null;
            }
            if (empty($this->table)) {
                // If still not set, return empty SQL to avoid fatal error
                return '';
            }
        }

        if ($this->operation === 'select') {
            $columns = is_array($this->columns) ? $this->columns : [$this->columns];
            $cols = implode(', ', array_map(function ($col) {
                return $this->aliases[$col] ?? $col;
            }, $columns));

            $sql .= "SELECT {$cols} FROM {$this->table}";

            if ($this->joins) {
                $sql .= ' ' . implode(' ', $this->joins);
            }

            if ($this->wheres || $this->orWheres || $this->whereNulls) {
                $sql .= ' WHERE ';
                $conditions = [];

                foreach ($this->wheres as [$col, $op, $val, $neg]) {
                    $param = ':' . str_replace('.', '_', $col) . count($this->bindings);
                    $conditions[] = ($neg ? "NOT " : "") . "$col $op $param";
                    $this->bindings[$param] = $val;
                }

                foreach ($this->whereNulls as [$col, $neg]) {
                    $conditions[] = "$col IS " . ($neg ? "NOT NULL" : "NULL");
                }

                foreach ($this->orWheres as [$col, $op, $val]) {
                    $param = ':' . str_replace('.', '_', $col) . count($this->bindings);
                    $conditions[] = "OR $col $op $param";
                    $this->bindings[$param] = $val;
                }

                $sql .= implode(' AND ', $conditions);
            }

            if (!empty($this->groupBy)) {
                $groupByCols = is_array($this->groupBy) ? implode(', ', $this->groupBy) : $this->groupBy;
                $sql .= ' GROUP BY ' . $groupByCols;
            }

            if (!empty($this->having)) {
                $sql .= ' HAVING ' . implode(' AND ', array_map(function ($h) {
                    return "{$h[0]} {$h[1]} '{$h[2]}'";
                }, $this->having));
            }

            if ($this->orderBy) {
                $sql .= ' ' . $this->orderBy;
            }

            if ($this->limit !== null) {
                $sql .= ' LIMIT ' . $this->limit;
            }

            if ($this->offset !== null) {
                $sql .= ' OFFSET ' . $this->offset;
            }
        } elseif ($this->operation === 'insert') {
            // insert handled separately
        } elseif ($this->operation === 'update') {
            // update handled separately
        } elseif ($this->operation === 'delete') {
            // delete handled separately
        }

        return $sql;
    }

    protected function executeInsert()
    {
        $columns = implode(', ', array_keys($this->insertData));
        $params = ':' . implode(', :', array_keys($this->insertData));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($params)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->insertData);
    }

    protected function executeUpdate()
    {
        $setParts = [];
        foreach ($this->updateData as $col => $val) {
            $setParts[] = "$col = :update_$col";
            $this->bindings[":update_$col"] = $val;
        }

        // Assume only one WHERE clause for primary key
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts);
        if ($this->wheres) {
            [$col, $op, $val] = $this->wheres[0];
            $sql .= " WHERE $col $op :id";
            $this->bindings[':id'] = $val;
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }

    protected function executeDelete()
    {
        // Assume only one WHERE clause for primary key
        $sql = "DELETE FROM {$this->table}";
        if ($this->wheres) {
            [$col, $op, $val] = $this->wheres[0];
            $sql .= " WHERE $col $op :id";
            $this->bindings = [':id' => $val];
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }
}
