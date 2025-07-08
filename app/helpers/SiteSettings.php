<?php

namespace App\Helpers;

class SiteSettings
{
    protected static function getConfigPath()
    {
        $username = isset($_SESSION['user_id']) ? (\App\Models\User::find($_SESSION['user_id'])->username ?? 'default') : 'default';
        return project_root('config/site_settings_' . $username . '.json');
    }

    public static function all()
    {
        $path = self::getConfigPath();
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) return $data;
        }
        return [];
    }

    public static function get($key, $default = null)
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $all = self::all();
        $all[$key] = $value;
        self::save($all);
    }

    public static function save($data)
    {
        $path = self::getConfigPath();
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
