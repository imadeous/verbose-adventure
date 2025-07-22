<?php

namespace Core;

abstract class Model


{
    // Common model functionality goes here
    /**
     * The route key for model binding in resource routes (default: 'id').
     * Override in child models to use a different column (e.g., 'username', 'slug').
     */
    public static $routeKey = 'id';
    // Optionally, you can define a protected $table property in child models
    protected $table = null;
    protected $primaryKey = 'id';
    protected $attributes = [];
    /**
     * Begin a query with a custom select clause.
     * @param string|array $columns
     * @return \Core\Database\QueryBuilder
     */
    public static function select($columns)
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        return $qb->select($columns);
    }

    /**
     * Get the count of all records in the table.
     * @return int
     */
    public static function count(): int
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        if (method_exists($qb, 'count')) {
            return $qb->count();
        }
        // Fallback: count all rows manually if QueryBuilder has no count()
        $rows = $qb->all();
        return is_array($rows) ? count($rows) : 0;
    }


    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Mass-assign attributes to the model instance.
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    // --- Active Record style methods ---
    public static function all()
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        $rows = $qb->all();
        return array_map(fn($row) => new static($row), $rows);
    }

    public static function find($id)
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        $row = $qb->find($id, $instance->primaryKey);
        return $row ? new static($row) : null;
    }

    public static function where($column, $operator = null, $value = null)
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        return $qb->where($column, $operator, $value);
    }


    /**
     * Get records where a column is NULL.
     * @param string $column
     * @return array
     */
    public static function whereNull($column)
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        $rows = $qb->whereNull($column)->get();
        return array_map(fn($row) => new static($row), $rows);
    }

    /**
     * Get sorted model objects by column and direction.
     *
     * @param string|array $selectArray Columns to select (e.g. '*', ['id','name'])
     * @param string $orderby Column to order by
     * @param string $direction 'asc' or 'desc'
     * @return array Array of model objects
     */
    public static function sort($selectArray = '*', $orderby = 'id', $direction = 'asc')
    {
        $instance = new static();
        $qb = new \Core\Database\QueryBuilder($instance->table);
        $rows = $qb->select($selectArray)->orderBy($orderby, $direction)->get();
        return array_map(fn($row) => new static($row), $rows);
    }


    public function save()
    {
        $qb = new \Core\Database\QueryBuilder($this->table);
        // Remove CSRF field if present
        $data = $this->attributes;
        unset($data['_csrf']);
        if (!empty($this->attributes[$this->primaryKey])) {
            // Update
            $id = $this->attributes[$this->primaryKey];
            unset($data[$this->primaryKey]);
            return $qb->update($id, $data, $this->primaryKey);
        } else {
            // Insert
            $id = $qb->insert($data);
            $this->attributes[$this->primaryKey] = $id;
            return $id;
        }
    }

    public function delete()
    {
        if (empty($this->attributes[$this->primaryKey])) return false;
        $qb = new \Core\Database\QueryBuilder($this->table);
        return $qb->delete($this->attributes[$this->primaryKey], $this->primaryKey);
    }
}

// write the example sysntax for the Model class
// Example usage:
// $user = new User(['username' => 'john_doe', 'email' => 'john@example.com']);
// $user->save();
// $users = User::all();
// $user = User::find(1);
// $user->delete();  