<?php

namespace App\Helpers;

use App\Models\User;
use Core\Session;

class Auth
{
    /**
     * Log the given user in.
     *
     * @param User $user
     */
    public static function login(User $user)
    {
        session()->set('user_id', $user->id);
    }

    /**
     * Log the user out.
     */
    public static function logout()
    {
        session()->destroy();
    }

    /**
     * Check if a user is authenticated.
     *
     * @return bool
     */
    public static function check(): bool
    {
        return session()->has('user_id');
    }

    /**
     * Check if the current user is a guest.
     *
     * @return bool
     */
    public static function guest(): bool
    {
        return !self::check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public static function user(): ?User
    {
        if (self::check()) {
            return User::find(self::id());
        }
        return null;
    }

    /**
     * Get the ID of the currently authenticated user.
     *
     * @return int|null
     */
    public static function id(): ?int
    {
        return session()->get('user_id');
    }
}
