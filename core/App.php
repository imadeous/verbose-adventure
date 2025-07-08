<?php

namespace Core;

class App
{
    /**
     * The application service registry.
     * @var array
     */
    protected static $registry = [];

    /**
     * Bind a value or service to the container.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Retrieve a value or service from the container.
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key)
    {
        if (! array_key_exists($key, static::$registry)) {
            throw new \Exception("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }
}
