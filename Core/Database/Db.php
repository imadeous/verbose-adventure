<?php

namespace Core\Database;

use PDO;

class Db
{
    protected static $instance = null;

    public static function instance()
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST');
            $database = getenv('DB_DATABASE');
            $username = getenv('DB_USERNAME');
            $password = getenv('DB_PASSWORD');

            var_dump(getenv('TELEGRAM_BOT_TOKEN'), getenv('TELEGRAM_CHAT_IDS'));
            die();

            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $database);
            self::$instance = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$instance;
    }
}
