<?php

namespace Helpers;

class Text
{
    /**
     * Convert a string to snake_case.
     */
    public static function snake(string $value): string
    {
        $value = preg_replace('/[A-Z]/', '_$0', $value);
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9_]+/', '_', $value);
        return trim($value, '_');
    }

    /**
     * Convert a string to camelCase.
     */
    public static function camel(string $value): string
    {
        $value = str_replace(['-', '_'], ' ', $value);
        $value = ucwords($value);
        $value = str_replace(' ', '', $value);
        $value = lcfirst($value);
        return $value;
    }

    /**
     * Convert a string to StudlyCase (PascalCase).
     */
    public static function studly(string $value): string
    {
        $value = str_replace(['-', '_'], ' ', $value);
        $value = ucwords($value);
        $value = str_replace(' ', '', $value);
        return $value;
    }

    /**
     * Limit the number of characters in a string.
     */
    public static function limit(string $value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }
        return mb_substr($value, 0, $limit) . $end;
    }

    /**
     * Check if a string starts with a given substring.
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }

    /**
     * Check if a string ends with a given substring.
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
    }

    /**
     * Check if a string contains a given substring.
     */
    public static function contains(string $haystack, string $needle): bool
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }

    /**
     * Generate a random alpha-numeric string.
     */
    public static function random(int $length = 16): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $result;
    }

    /**
     * Convert a string to a URL-friendly slug.
     */
    public static function slug(string $value, string $separator = '-'): string
    {
        // Convert to ASCII
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        // Replace non letter or digits by separator
        $value = preg_replace('~[^\pL\d]+~u', $separator, $value);
        // Remove unwanted characters
        $value = preg_replace('~[^-a-zA-Z0-9]+~', '', $value);
        // Trim
        $value = trim($value, $separator);
        // Lowercase
        $value = strtolower($value);
        // Remove duplicate separators
        $value = preg_replace('~' . preg_quote($separator, '~') . '+~', $separator, $value);
        return $value;
    }
}
