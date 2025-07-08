<?php

namespace Core;

use Core\Request;

class Csrf
{
    public static function generate()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verify($token)
    {
        if (isset($_SESSION['csrf_token']) && !empty($token) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    public static function check()
    {
        $token = Request::input('_token') ?? Request::input('csrf_token');

        if (!self::verify($token)) {
            // You can customize the error response, e.g., throw an exception or redirect.
            http_response_code(403);
            die('CSRF token validation failed.');
        }
    }

    public static function input()
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generate() . '">';
    }
}
