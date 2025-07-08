<?php
if (!function_exists('csrf')) {
    function csrf()
    {
        return \Core\Csrf::input();
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        return \Core\Csrf::generate();
    }
}

if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        return url($path);
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        return isset($_SESSION['user_id']) ? \App\Models\User::find($_SESSION['user_id']) : null;
    }
}

if (!function_exists('login')) {
    function login($user)
    {
        $_SESSION['user_id'] = $user->id;
    }
}

if (!function_exists('logout')) {
    function logout()
    {
        unset($_SESSION['user_id']);
        session_destroy();
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return \Core\Csrf::input();
    }
}

if (!function_exists('add_query_arg')) {
    function add_query_arg(array $args)
    {
        $params = $_GET;
        foreach ($args as $k => $v) {
            $params[$k] = $v;
        }
        return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($params);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given path.
     *
     * @param string $path
     * @return void
     */
    function redirect($path)
    {
        header("Location: " . url($path));
        exit();
    }
}

if (!function_exists('current_url')) {
    /**
     * Get the full current URL.
     *
     * @return string
     */
    function current_url()
    {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        return $protocol . "://" . $host . $uri;
    }
}

if (!function_exists('project_root')) {
    /**
     * Get the absolute path to the project root.
     *
     * @param string $path
     * @return string
     */
    function project_root($path = '')
    {
        // __DIR__ is the directory of the current file (app/helpers)
        // dirname(__DIR__, 2) goes up two levels to the project root
        $root = dirname(__DIR__, 2);
        return $root . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

if (!function_exists('base_path')) {
    function base_path()
    {
        // This function is designed to return the base path of the application,
        // relative to the web server's document root.
        // It correctly handles cases where the app is in a subdirectory.
        $script_name = dirname($_SERVER['SCRIPT_NAME']);
        // Remove /public from the path, as it's part of the app structure, not the base URL path
        $base_path = str_replace('/public', '', $script_name);
        return rtrim($base_path, '/');
    }
}

if (!function_exists('url')) {
    /**
     * Generate a full URL to a path.
     *
     * @param string $path
     * @return string
     */
    function url($path = '')
    {
        $base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $base_path = base_path();
        // Remove leading slash from $path to avoid double slashes
        $path = ltrim($path, '/');
        return $base . $base_path . '/' . $path;
    }
}

if (!function_exists('storage_url')) {
    /**
     * Generate a full URL to a path in the storage directory.
     *
     * @param string $path
     * @return string
     */
    function storage_url($path = '')
    {
        return url('storage/' . ltrim($path, '/'));
    }
}

function format_bytes($bytes, $precision = 2)
{
    if ($bytes === null) {
        return 'N/A';
    }
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}

if (!function_exists('session')) {
    /**
     * Get the session instance.
     *
     * @return \Core\Session
     */
    function session()
    {
        static $session = null;
        if ($session === null) {
            $session = new \Core\Session();
        }
        return $session;
    }
}
