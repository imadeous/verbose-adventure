<?php

namespace Core;

class Session
{

    /**
     * Initialize the session if it hasn't started.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    /**
     * Set a session value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    /**
     * Get a session value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }


    /**
     * Check if a session key exists.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }


    /**
     * Remove a session key.
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }


    /**
     * Get a session value and remove it (flash message).
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function flash($key, $default = null)
    {
        if ($this->has($key)) {
            $value = $this->get($key, $default);
            $this->remove($key);
            return $value;
        }
        return $default;
    }


    /**
     * Flash an array of errors to the session.
     *
     * @param array $errors
     * @return void
     */
    public function flashErrors(array $errors)
    {
        $this->set('errors', $errors);
    }


    /**
     * Destroy the session and clear all session data.
     *
     * @return void
     */
    public function destroy()
    {
        session_destroy();
        $_SESSION = [];
    }
}
