<?php

namespace Core;

use Core\Request;

class Csrf
{

    /**
     * Generate and return a CSRF token, storing it in the session if not already set.
     *
     * @return string
     */
    public static function generate()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }


    /**
     * Verify a CSRF token against the session value.
     *
     * @param string $token
     * @return bool
     */
    public static function verify($token)
    {
        if (isset($_SESSION['csrf_token']) && !empty($token) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }


    /**
     * Check the CSRF token from the request and terminate if invalid.
     *
     * @return void
     */
    public static function check()
    {
        $token = Request::input('_token') ?? Request::input('csrf_token');

        if (!self::verify($token)) {
            // You can customize the error response, e.g., throw an exception or redirect.
            http_response_code(403);
            die('CSRF token validation failed.');
        }
    }


    /**
     * Generate a hidden input field with the CSRF token for use in forms.
     *
     * @return string
     */
    public static function input()
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generate() . '">';
    }
}
