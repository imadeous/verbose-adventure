<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;
use App\Helpers\Csrf;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            header('Location: ' . url('admin'));
            exit;
        }
        $this->view('auth/login');
    }

    public function login()
    {
        // CSRF check
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['_csrf']) || !Csrf::check($_POST['_csrf'])) {
            flash('error', 'Invalid request or CSRF token.');
            $this->view('auth/login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            flash('error', 'Valid email and password are required.');
            $this->view('auth/login');
            return;
        }

        // Use new query builder syntax to find user by email
        $userRow = User::query()
            ->where('email', '=', $email)
            ->limit(1)
            ->get();
        $user = !empty($userRow) ? new User($userRow[0]) : null;

        // Security: timing attack safe password check
        if ($user && hash_equals($user->password, crypt($password, $user->password)) && password_verify($password, $user->password)) {
            Auth::login($user->id);
            flash('success', 'Welcome back!');
            header('Location: ' . url('admin')); // Redirect to admin dashboard
            exit;
        }

        flash('error', 'Invalid credentials.');
        $this->view('auth/login');
    }

    public function logout()
    {
        // CSRF check for POST logout
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['_csrf']) || !Csrf::check($_POST['_csrf'])) {
                flash('error', 'Invalid CSRF token.');
                header('Location: ' . url('login'));
                exit;
            }
        }
        Auth::logout();
        header('Location: ' . url('login'));
        exit;
    }
}
