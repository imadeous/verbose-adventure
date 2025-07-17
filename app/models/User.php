<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public static $routeKey = 'username'; // Default route key for user model

    // Find user by email
    public static function findByAttribute($email, $attribute = 'email')
    {
        $results = parent::where($attribute, $email);
        return $results ? $results[0] : null;
    }
}
