<?php

namespace Core\Database;

use Core\Database\Db;
use PDO;


class QueryBuilder


{
    protected $table;
    protected $pdo;
    protected $select = '*';
    protected $wheres = [];
    protected $bindings = [];
    protected $orderBy = '';
    protected $limit = '';

    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = Db::instance();
    }

    public function select($columns)
    {
        if (is_array($columns)) {
            $this->select = '`' . implode('`,`', $columns) . '`';
        } else {
            $this->select = $columns;
        }
        return $this;
    }

    protected $joins = [];
    /**
     * Add a JOIN clause to the query.
     * @param string $table
     * @param string $first
     * @param string $operator
     * @param string $second
     * @param string $type
     * @return $this
     */
    public function join($table, $first, $operator, $second, $type = 'INNER')
    {
        $this->joins[] = strtoupper($type) . " JOIN `$table` ON $first $operator $second";
        return $this;
    }

    public function where($column, $operator, $value = null)
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = ["$column $operator ?"];
        $this->bindings[] = $value;
        return $this;
    }

    public function orWhere($column, $operator, $value = null)
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = ["OR $column $operator ?"];
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Add an explicit AND WHERE clause to the query.
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return $this
     */
    public function andWhere($column, $operator, $value = null)
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = ["AND $column $operator ?"];
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Add a "where IS NULL" clause to the query.
     * @param string $column
     * @return $this
     */
    public function whereNull($column)
    {
        $this->wheres[] = ["$column IS NULL"];
        // No binding needed for IS NULL
        return $this;
    }

    /**
     * Get the count of rows matching the current query.
     * @return int
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM `{$this->table}`";
        $params = [];
        if (!empty($this->wheres)) {
            $whereClauses = [];
            foreach ($this->wheres as $where) {
                $whereClauses[] = $where[0] . ' ' . $where[1] . ' ?';
                $params[] = $where[2];
            }
            $sql .= ' WHERE ' . implode(' AND ', $whereClauses);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['count'] ?? 0);
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "ORDER BY `$column` $direction";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = "LIMIT $limit";
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->select} FROM `{$this->table}`";
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if ($this->wheres) {
            $whereSql = [];
            foreach ($this->wheres as $i => $where) {
                $whereSql[] = ($i === 0 ? 'WHERE ' : '') . $where[0];
            }
            $sql .= ' ' . implode(' ', $whereSql);
        }
        if ($this->orderBy) {
            $sql .= ' ' . $this->orderBy;
        }
        if ($this->limit) {
            $sql .= ' ' . $this->limit;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        $results = $stmt->fetchAll();
        // Reset state for next query
        $this->select = '*';
        $this->wheres = [];
        $this->bindings = [];
        $this->orderBy = '';
        $this->limit = '';
        $this->joins = [];
        return $results;
    }

    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }

    public function all()
    {
        return $this->get();
    }

    public function find($id, $primaryKey = 'id')
    {
        return $this->where($primaryKey, $id)->first();
    }

    public function insert($data)
    {
        $columns = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        $sql = "INSERT INTO `{$this->table}` (`" . implode('`,`', $columns) . "`) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data, $primaryKey = 'id')
    {
        $columns = array_keys($data);
        $set = implode(', ', array_map(function ($col) {
            return "`$col` = ?";
        }, $columns));
        $sql = "UPDATE `{$this->table}` SET $set WHERE `$primaryKey` = ?";
        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete($id, $primaryKey = 'id')
    {
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `$primaryKey` = ?");
        return $stmt->execute([$id]);
    }
}
