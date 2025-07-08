<?php

namespace Core;

class Request
{
    /**
     * Get the current request URI.
     *
     * @return string
     */
    public static function uri()
    {
        $uri = trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
        );

        $basePath = trim(base_path(), '/');

        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        return trim($uri, '/');
    }

    /**
     * Get the current request method.
     *
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get data from the POST request.
     *
     * @param string|null $key
     * @return mixed
     */
    public static function post($key = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? null;
    }

    /**
     * Get a value from the request payload.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function input($key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    /**
     * Get all input from the request payload.
     *
     * @return array
     */
    public static function all()
    {
        return $_REQUEST;
    }

    /**
     * Get an uploaded file from the request.
     *
     * @param string $key
     * @return array|null
     */
    public static function file($key)
    {
        return $_FILES[$key] ?? null;
    }
}
