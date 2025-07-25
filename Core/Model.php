<?php

namespace Core;

use Core\Database\QueryBuilder;

abstract class Model
{
    public static string $routeKey = 'id';
    protected ?string $table = null;
    protected string $primaryKey = 'id';
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    // ------------------------------
    //  ATTRIBUTES
    // ------------------------------

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function fill(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    // ------------------------------
    //  QUERY ENTRY POINT
    // ------------------------------

    public static function newQuery(): QueryBuilder
    {
        return new QueryBuilder((new static())->getTable());
    }

    public static function getQueryBuilder(): QueryBuilder
    {
        return static::newQuery();
    }

    protected function getTable(): string
    {
        if (!isset($this->table)) {
            throw new \Exception("Table name not set. Please define protected \$table in your model.");
        }
        return $this->table;
    }


    // ------------------------------
    //  STATIC FLUENT INTERFACE
    // ------------------------------

    public static function select(array|string $columns): QueryBuilder
    {
        return static::newQuery()->select($columns, (new static())->getTable());
    }

    public static function where(string $column, mixed $operatorOrValue, mixed $value = null): QueryBuilder
    {
        return static::newQuery()->where($column, $operatorOrValue, $value);
    }

    public static function whereNull(string $column): QueryBuilder
    {
        return static::newQuery()->whereNull($column);
    }

    public static function whereNotNull(string $column): QueryBuilder
    {
        return static::newQuery()->whereNotNull($column);
    }

    public static function join(string $table, string $localKey, string $operator, string $foreignKey): QueryBuilder
    {
        return static::newQuery()->join($table, $localKey, $operator, $foreignKey);
    }

    public static function groupBy(string|array $columns): QueryBuilder
    {
        return static::newQuery()->groupBy($columns);
    }

    // /**
    //  * Chainable method to group result sets into arrays by a column after fetching.
    //  * @param string $column
    //  * @return QueryBuilder
    //  */
    // public static function groupResultsBy(string $column): QueryBuilder
    // {
    //     return static::newQuery()->groupResultsBy($column);
    // }

    public static function having(string $column, string $operator, mixed $value): QueryBuilder
    {
        return static::newQuery()->having($column, $operator, $value);
    }

    public static function orderBy(string $column, string $direction = 'asc'): QueryBuilder
    {
        return static::newQuery()->orderBy($column, $direction);
    }

    public static function limit(int $limit): QueryBuilder
    {
        return static::newQuery()->limit($limit);
    }

    public static function offset(int $offset): QueryBuilder
    {
        return static::newQuery()->offset($offset);
    }

    public static function count(): int
    {
        return static::newQuery()->count();
    }

    public static function all(): array
    {
        return array_map(fn($row) => new static($row), static::newQuery()->get());
    }

    public static function query()
    {
        return new QueryBuilder((new static())->getTable());
    }

    public static function find($id): ?static
    {
        $instance = new static();
        $row = static::newQuery()->find($id, $instance->primaryKey);
        return $row ? new static($row) : null;
    }


    // ------------------------------
    //  SORTING CONVENIENCE
    // ------------------------------

    public static function sort($select = '*', $orderby = 'id', $direction = 'asc'): array
    {
        return array_map(
            fn($row) => new static($row),
            static::query()->select($select)->orderBy($orderby, $direction)->get()
        );
    }

    // ------------------------------
    //  ACTIVE RECORD STYLE
    // ------------------------------

    /**
     * Save a new record to the database (insert only).
     */
    public function save(): int|bool
    {
        $qb = new QueryBuilder($this->getTable());
        $data = $this->attributes;
        unset($data['_csrf']);

        $id = $qb->insert($data);
        $this->attributes[$this->primaryKey] = $id;
        return $id;
    }

    /**
     * Update an existing record in the database.
     */
    public function update(): bool
    {
        if (empty($this->attributes[$this->primaryKey]) || $this->attributes[$this->primaryKey] === null) {
            return false;
        }
        $qb = new QueryBuilder($this->getTable());
        $data = $this->attributes;
        unset($data['_csrf']);
        $id = $this->attributes[$this->primaryKey];
        unset($data[$this->primaryKey]);
        return $qb->update($data, $id, $this->primaryKey);
    }

    public function delete(): bool
    {
        if (empty($this->attributes[$this->primaryKey])) return false;
        $qb = new QueryBuilder($this->getTable());
        return $qb->delete($this->attributes[$this->primaryKey], $this->primaryKey);
    }
}
