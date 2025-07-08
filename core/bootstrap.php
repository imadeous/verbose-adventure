<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// use App\Helpers\Auth;
use Core\App;
use Core\Database\QueryBuilder;
use Core\Database\Connection;
use Core\Csrf;
use Core\View;

require_once __DIR__ . '/../app/helpers/Functions.php';
require_once __DIR__ . '/../app/helpers/Session.php';

App::bind('config', require __DIR__ . '/../config/database.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

// Use a reliable method to get the project root directory
$projectRoot = dirname(__DIR__) . DIRECTORY_SEPARATOR;
App::bind('view', new View($projectRoot));

function view($name = null, $data = [])
{
    if (is_null($name)) {
        return App::get('view');
    }
    return App::get('view')->make($name, $data);
}
