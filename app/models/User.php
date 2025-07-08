<?php

namespace App\Models;

use Core\Model;

/**
 * User model
 *
 * Represents an application user (admin or regular user).
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $avatar
 */
class User extends Model
{
    protected static $table = 'users';
    protected static $fillable = ['username', 'email', 'password', 'role'];
    public string $password_confirm = '';

    /**
     * Validation rules for the User model.
     * @return array
     */
    public static function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'password_confirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    /**
     * Get the avatar URL for the user.
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Check if it's a full URL or just a path
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            // Assuming it's a path relative to the public/storage directory
            return storage_url($this->avatar);
        }
        // Return a default avatar URL
        return storage_url('default-avatar.svg');
    }

    /**
     * Save the user, hashing the password if needed.
     * @return $this
     */
    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
}
