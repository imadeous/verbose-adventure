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

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    public static function table($table)
    {
        $instance = new static();
        $instance->table = $table;
        return $instance;
    }

    public static function select($columns = ['*'])
    {
        $instance = new static();
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
        $this->groupBy = array_merge($this->groupBy, $columns);
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

    public function update(array $data)
    {
        $this->operation = 'update';
        $this->updateData = $data;
        return $this->executeUpdate();
    }

    public function delete()
    {
        $this->operation = 'delete';
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
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id, $primaryKey = 'id')
    {
        // Make sure $this->table is set and used
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

        if ($this->operation === 'select') {
            $cols = implode(', ', array_map(function ($col) {
                return $this->aliases[$col] ?? $col;
            }, $this->columns));

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
                $sql .= ' GROUP BY ' . implode(', ', $this->groupBy);
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

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts);
        if ($this->wheres) {
            $sql .= ' WHERE ' . implode(' AND ', array_map(function ($w) {
                return "{$w[0]} {$w[1]} :{$w[0]}" . count($this->bindings);
            }, $this->wheres));
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }

    protected function executeDelete()
    {
        $sql = "DELETE FROM {$this->table}";
        if ($this->wheres) {
            $sql .= ' WHERE ' . implode(' AND ', array_map(function ($w) {
                return "{$w[0]} {$w[1]} :{$w[0]}" . count($this->bindings);
            }, $this->wheres));
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }
}
