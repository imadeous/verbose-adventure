<?php
// This file is part of the YesFunadhoo project
// It contains helper functions for the application 
if (!function_exists('base_path')) {
    /**
     * Get the base path for the app (subfolder, if any), always starting with / and never ending with / (unless root)
     * @return string
     */
    function base_path(): string
    {
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
        $dir = rtrim(dirname($scriptName), '/');
        // Remove /public if present (for subfolder installs)
        $base = preg_replace('#/public$#', '', $dir);
        return ($base === '' || $base === '/') ? '' : $base;
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML special characters
     * @param string|null $value
     * @return string
     */
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('url')) {
    /**
     * Generate a URL relative to the site root.
     * @param string|null $path
     * @return string
     */
    function url(?string $path = null): string
    {
        $base = base_path();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $url = $protocol . $host;
        if ($base) {
            $url .= $base;
        }
        if ($path) {
            $url .= '/' . ltrim($path, '/');
        }
        return $url;
    }
}

// ...existing code...
if (!function_exists('flash')) {
    /**
     * Set or get a flash message in the session.
     * Usage:
     * flash('error', 'Something went wrong!'); // set
     * flash('success', 'Welcome!'); // set
     * $msg = flash('error'); // get and clear
     * $msg = flash(); // get all and clear
     */
    function flash($key = null, $value = null)
    {
        if (!isset($_SESSION)) session_start();
        if ($key && $value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return true;
        }
        if ($key) {
            $msg = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $msg;
        }
        $all = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $all;
    }
}
if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        $token = \App\Helpers\Csrf::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
