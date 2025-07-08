<?php

/**
 * Database configuration for the Craft PHP MVC framework.
 *
 * This file returns an array of database connection settings used by the application.
 *
 * @return array{
 *   database: array{
 *     name: string,         // Database name
 *     username: string,     // Database username
 *     password: string,     // Database password
 *     connection: string,   // PDO DSN connection string
 *     options: array        // PDO options
 *   }
 * }
 */

return [
    'database' => [
        'name' => 'craft_db',
        'username' => 'root',
        'password' => '',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
