<?php

namespace App\Models;

use Core\Model;


class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public static $routeKey = 'username'; // Default route key for user model
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'verified_at',
        'created_at',
        'forgot_key',
    ];

    public function __construct($attributes = [])
    {
        $this->attributes = is_array($attributes) ? $attributes : [];
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    // Find user by email
    public static function findByAttribute($value, $attribute = 'email')
    {
        $result = static::query()
            ->where($attribute, '=', $value)
            ->limit(1)
            ->get();
        return !empty($result) ? new static($result[0]) : null;
    }
}
