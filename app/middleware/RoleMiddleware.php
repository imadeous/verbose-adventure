<?php

namespace App\Middleware;

use App\Helpers\Auth;
use Core\Session;

class RoleMiddleware
{
    /**
     * The role required to access the route.
     *
     * @var string
     */
    protected $role;

    /**
     * Create a new middleware instance.
     *
     * @param string $role
     */
    public function __construct($role = 'admin')
    {
        $this->role = $role;
    }

    /**
     * Handle the incoming request.
     *
     */
    public function handle()
    {
        if (!Auth::check() || Auth::user()->role !== $this->role) {
            session()->flash('error', 'You do not have permission to access this page.');
            redirect('/');
        }
    }
}
