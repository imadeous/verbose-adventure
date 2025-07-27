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

if (!function_exists('asset')) {
    /**
     * Generate a URL for an asset in the public folder.
     * Example usage:
     *   <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
     *   <img src="<?= asset('images/logo.png') ?>">
     * @param string $path
     * @return string
     */
    function asset(string $path): string
    {
        $base = base_path();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $url = $protocol . $host;
        if ($base) {
            $url .= $base;
        }
        $url .= '/' . ltrim($path, '/');
        return $url;
    }
}

if (!function_exists('number_shorten')) {
    /**
     * Shorten large numbers with K, M, B, T suffixes (e.g. 1.2K, 3.4M)
     * @param float|int $number
     * @param int $precision
     * @return string
     */
    function number_shorten($number, $precision = 1): string
    {
        if (!is_numeric($number)) return (string)$number;
        $abs = abs($number);
        if ($abs < 1000) {
            return number_format($number, $precision);
        }
        $units = [
            12 => 'T', // Trillion
            9 => 'B',  // Billion
            6 => 'M',  // Million
            3 => 'K',  // Thousand
        ];
        foreach ($units as $exp => $unit) {
            if ($abs >= pow(10, $exp)) {
                return number_format($number / pow(10, $exp), $precision) . $unit;
            }
        }
        return number_format($number, $precision);
    }
}
if (!function_exists('is_null')) {
    /**
     * Check if a variable is null
     * @param mixed $var
     * @return bool
     */
    function is_null($var): bool
    {
        return $var === null;
    }
}
