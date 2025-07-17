<?php

namespace App\Middleware;

use App\Helpers\Auth;

class AuthMiddleware
{
    public static function handle()
    {
        if (!Auth::check()) {
            header('Location: ' . url('login'));
            exit;
        }
    }
}
