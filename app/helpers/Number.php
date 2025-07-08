<?php
// helpers/Number.php

namespace Helpers;

class Number
{
    /**
     * Format a number with grouped thousands.
     */
    public static function format($number, int $decimals = 0, string $dec_point = '.', string $thousands_sep = ','): string
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }

    /**
     * Convert bytes to a human-readable format (e.g., KB, MB, GB).
     */
    public static function bytesToHuman($bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $bytes = max($bytes, 0);
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Pad a number with zeros on the left.
     */
    public static function padLeft($number, int $length): string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Pad a number with zeros on the right.
     */
    public static function padRight($number, int $length): string
    {
        return str_pad($number, $length, '0', STR_PAD_RIGHT);
    }

    /**
     * Generate a random integer between min and max (inclusive).
     */
    public static function random(int $min, int $max): int
    {
        return random_int($min, $max);
    }

    /**
     * Check if a value is an integer.
     */
    public static function isInt($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Check if a value is a float.
     */
    public static function isFloat($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }
}
