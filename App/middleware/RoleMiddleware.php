<?php

namespace App\Middleware;

use App\Helpers\Auth;

class RoleMiddleware
{
    /**
     * Handle the request and check for required role(s).
     * Usage: RoleMiddleware::handle('admin') or RoleMiddleware::handle(['admin', 'editor'])
     *
     * @param string|array $role
     */
    public static function handle($role = 'admin')
    {
        if (!Auth::check()) {
            header('Location: ' . url('/login'));
            exit;
        }
        $user = Auth::user();
        $roles = is_array($role) ? $role : [$role];
        if (!in_array($user->role ?? null, $roles, true)) {
            http_response_code(403);
            echo '<h1>403 Forbidden</h1><p>You do not have permission to access this page.</p>';
            exit;
        }
    }
}
