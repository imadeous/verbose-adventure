<?php

namespace App\Helpers;

use App\Models\User;

class Auth
{
    /**
     * Check if a user is logged in.
     * @return bool
     */
    public static function check(): bool
    {
        return isset($_SESSION['user_id']) && User::find($_SESSION['user_id']);
    }

    /**
     * Get the currently logged in user, or null if not logged in.
     * @return User|null
     */
    public static function user()
    {
        return isset($_SESSION['user_id']) ? User::find($_SESSION['user_id']) : null;
    }

    /**
     * Check if the current user is logged in and is an admin.
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $user = self::user();
        return Auth::user()->role === 'admin' && $user !== null;
    }

    /**
     * Log in a user by their user ID.
     * @param int|string $userId
     * @return void
     */
    public static function login($userId): void
    {
        $_SESSION['user_id'] = $userId;
    }

    /**
     * Log out the current user and destroy the session.
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user_id']);
        session_destroy();
    }
}
