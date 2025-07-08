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

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

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

    public static function all()
    {
        $results = App::get('database')->selectAll(static::getTable());
        return array_map(fn($row) => new static($row), $results);
    }

    public static function find($id)
    {
        $result = App::get('database')->table(static::getTable())->find($id, static::$primaryKey);
        return $result ? new static($result) : null;
    }

    public static function query()
    {
        return App::get('database')->table(static::getTable())->setModel(static::class);
    }

    public static function where($column, $operator, $value = null)
    {
        $query = static::query();

        if (func_num_args() === 2) {
            return $query->where($column, '=', $operator);
        }

        return $query->where($column, $operator, $value);
    }

    public static function create(array $attributes)
    {
        $model = new static($attributes);
        $model->save();
        return $model;
    }

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

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->__set($key, $value);
        }
        return $this;
    }

    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
            $this->__set($key, $value);
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

    // Validation methods
    abstract public static function rules(): array;

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

    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

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

    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function getFirstError($attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
