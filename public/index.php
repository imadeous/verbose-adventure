<?php
// Start session before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// The following duplicate PHP opening tag and session_start block have been removed.
use Core\Router;

require_once __DIR__ . '/../Core/Env.php';

use Core\Env;

Env::load(__DIR__ . '/../.env');
if (getenv('APP_MODE') === 'DEBUG') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/../App/Helpers/Functions.php';
require_once __DIR__ . '/../Core/Router.php';
require_once __DIR__ . '/../Core/View.php';
require_once __DIR__ . '/../Core/Controller.php';

spl_autoload_register(function ($class) {
    $prefixes = [
        'Core\\' => __DIR__ . '/../Core/',
        'App\\' => __DIR__ . '/../App/',
    ];
    foreach ($prefixes as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});

$router = new Router();
require __DIR__ . '/../routes/web.php';



// Get the URI robustly for both Windows and Linux hosting, using the same logic as url() helper
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require_once __DIR__ . '/../App/Helpers/Functions.php'; // ensure base_path() is available
$base = base_path();
if ($base && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
$uri = '/' . ltrim($uri, '/');

$router->direct($uri, $_SERVER['REQUEST_METHOD']);
