<?php

namespace App\Middleware;

use App\Helpers\Auth;

class AuthMiddleware
{
    public function handle()
    {
        if (Auth::guest()) {
            session()->set('error', 'You must be logged in to view this page.');
            redirect('/login');
            exit;
        }
    }
}
