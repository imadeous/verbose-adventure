<?php
// Usage: sanitize($input)
if (!function_exists('sanitize')) {
    function sanitize($value)
    {
        if (is_array($value)) {
            return array_map('sanitize', $value);
        }
        return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }
}
