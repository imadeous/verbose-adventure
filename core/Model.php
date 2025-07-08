<?php

namespace Core;

use Core\App;
use App\Core\Database\QueryBuilder;
use Exception;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_NUMBER = 'number';

    public array $errors = [];

    protected static $table;
    protected static $primaryKey = 'id';
    protected $attributes = [];


    /**
     * Model constructor. Optionally fill attributes.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }


    /**
     * Magic setter for model attributes.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }


    /**
     * Magic getter for model attributes.
     *
     * @param string $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }


    /**
     * Get the table name for the model.
     *
     * @return string
     */
    protected static function getTable()
    {
        if (static::$table) {
            return static::$table;
        }
        // A simple way to pluralize class names.
        // For more complex cases, a dedicated library might be better.
        $class = basename(str_replace('\\', '/', static::class));
        return strtolower($class) . 's';
    }


    /**
     * Get all records for the model.
     *
     * @return static[]
     */
    public static function all()
    {
        $results = App::get('database')->selectAll(static::getTable());
        return array_map(fn($row) => new static($row), $results);
    }


    /**
     * Find a record by its primary key.
     *
     * @param mixed $id
     * @return static|null
     */
    public static function find($id)
    {
        $result = App::get('database')->table(static::getTable())->find($id, static::$primaryKey);
        return $result ? new static($result) : null;
    }


    /**
     * Get a query builder instance for the model's table.
     *
     * @return \Core\Database\QueryBuilder
     */
    public static function query()
    {
        return App::get('database')->table(static::getTable())->setModel(static::class);
    }


    /**
     * Add a where clause to the query.
     *
     * @param string $column
     * @param string $operator
     * @param mixed|null $value
     * @return \Core\Database\QueryBuilder
     */
    public static function where($column, $operator, $value = null)
    {
        $query = static::query();

        if (func_num_args() === 2) {
            return $query->where($column, '=', $operator);
        }

        return $query->where($column, $operator, $value);
    }


    /**
     * Create and save a new model instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $model = new static($attributes);
        $model->save();
        return $model;
    }


    /**
     * Save the model to the database (insert or update).
     *
     * @return $this
     */
    public function save()
    {
        $pk = static::$primaryKey;
        $table = static::getTable();
        $db = App::get('database');

        $dataToSave = $this->attributes;

        if (isset($dataToSave[$pk])) {
            $id = $dataToSave[$pk];
            unset($dataToSave[$pk]); // Don't include PK in the update set
            $db->update($table, $id, $dataToSave, $pk);
        } else {
            $id = $db->insert($table, $dataToSave);
            $this->attributes[$pk] = $id;
        }
        return $this;
    }


    /**
     * Delete the model from the database.
     *
     * @return bool
     */
    public function delete()
    {
        $pk = static::$primaryKey;
        if (!isset($this->attributes[$pk])) {
            return false;
        }
        App::get('database')->delete(static::getTable(), $this->attributes[$pk], $pk);
        unset($this->attributes[$pk]);
        return true;
    }


    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->__set($key, $value);
        }
        return $this;
    }


    /**
     * Load data into the model, setting both properties and attributes.
     *
     * @param array $data
     * @return void
     */
    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
            $this->__set($key, $value);
        }
    }


    /**
     * Convert the model to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    // Validation methods
    abstract public static function rules(): array;


    /**
     * Validate the model's attributes against its rules.
     *
     * @return bool
     */
    public function validate()
    {
        foreach (static::rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = is_string($rule) ? $rule : $rule[0];

                if ($ruleName === self::RULE_REQUIRED && empty($value)) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_NUMBER && !is_numeric($value)) {
                    $this->addErrorForRule($attribute, self::RULE_NUMBER);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::getTable();
                    $statement = App::get('database')->prepare("SELECT * FROM {$tableName} WHERE {$uniqueAttr} = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }


    /**
     * Add an error message for a failed validation rule.
     *
     * @param string $attribute
     * @param string $rule
     * @param array $params
     * @return void
     */
    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }


    /**
     * Get the default error messages for validation rules.
     *
     * @return array
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
            self::RULE_NUMBER => 'This field must be a number',
        ];
    }


    /**
     * Check if the model has a validation error for an attribute.
     *
     * @param string $attribute
     * @return bool
     */
    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]);
    }


    /**
     * Get the first validation error for an attribute.
     *
     * @param string $attribute
     * @return string|null
     */
    public function getFirstError($attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }


    /**
     * Get all validation errors for the model.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
