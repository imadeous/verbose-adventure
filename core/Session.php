<?php

namespace Core;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function flash($key, $default = null)
    {
        if ($this->has($key)) {
            $value = $this->get($key, $default);
            $this->remove($key);
            return $value;
        }
        return $default;
    }

    public function flashErrors(array $errors)
    {
        $this->set('errors', $errors);
    }

    /**
     * Destroy the session.
     */
    public function destroy()
    {
        session_destroy();
        $_SESSION = [];
    }
}
