<?php

namespace Core\Database;

use PDO;

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $modelClass;
    protected $wheres = [];
    protected $bindings = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function where($column, $operator, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function get()
    {
        $sql = $this->toSql();
        $statement = $this->pdo->prepare($sql);
        $statement->execute($this->bindings);

        $result = $this->modelClass
            ? $statement->fetchAll(PDO::FETCH_CLASS, $this->modelClass)
            : $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->reset();
        return $result;
    }

    public function first()
    {
        $sql = $this->toSql() . " LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($this->bindings);

        if ($this->modelClass) {
            $statement->setFetchMode(PDO::FETCH_CLASS, $this->modelClass);
            $result = $statement->fetch();
        } else {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }

        $this->reset();
        return $result ?: null;
    }

    public function find($id, $primaryKey = 'id')
    {
        return $this->where($primaryKey, '=', $id)->first();
    }

    public function selectAll($table)
    {
        return $this->table($table)->get();
    }

    public function toSql()
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        return $sql;
    }

    protected function reset()
    {
        $this->table = null;
        $this->modelClass = null;
        $this->wheres = [];
        $this->bindings = [];
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            return $this->pdo->lastInsertId();
        } catch (\Exception $e) {
            // In a real app, you'd log this error.
            die('Whoops, something went wrong.');
        }
    }

    public function update($table, $id, $parameters, $primaryKey = 'id')
    {
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :id',
            $table,
            implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($parameters))),
            $primaryKey
        );

        $parameters['id'] = $id;

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (\Exception $e) {
            die('Whoops, something went wrong.');
        }
    }

    public function delete($table, $id, $primaryKey = 'id')
    {
        $sql = "DELETE FROM {$table} WHERE {$primaryKey} = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(['id' => $id]);
        } catch (\Exception $e) {
            die('Whoops, something went wrong.');
        }
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Execute a raw SQL query.
     *
     * @param string $sql The raw SQL string to execute.
     * @param array $bindings An array of bindings for the query.
     * @return \PDOStatement|false
     */
    public function raw($sql, $bindings = [])
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($bindings);
            return $statement;
        } catch (\Exception $e) {
            // Re-throw the exception to be handled by the caller
            throw $e;
        }
    }
    public function setModel($class)
    {
        $this->modelClass = $class;
        return $this;
    }
}
