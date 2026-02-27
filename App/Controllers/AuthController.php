<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Notifier;
use Exception;

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
        try {
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

            if (empty($userRow) || !isset($userRow[0]['password'])) {
                flash('error', 'Invalid credentials.');
                $this->view('auth/login');
                return;
            }

            $user = new User($userRow[0]);

            // Security: password_verify only
            if ($user && password_verify($password, $user->password)) {
                Auth::login($user->id);
                flash('success', 'Welcome back!');
                Notifier::notify(
                    'SUCCESS',
                    "User " . ($_SESSION['user']['email'] ?? 'unknown') . " logged in successfully."
                );
                header('Location: ' . url('admin'));
                exit;
            }

            flash('error', 'Invalid credentials.');
            Notifier::notify(
                'WARNING',
                "Failed login attempt for email: $email"
            );
            $this->view('auth/login');
        } catch (\Throwable $e) {
            flash('error', 'Login error: ' . $e->getMessage());
            Notifier::notify(
                'ERROR',
                "Login error for email: $email. Error: " . $e->getMessage()
            );
            $this->view('auth/login');
        }
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
        Notifier::notify(
            'INFO',
            "User " . ($_SESSION['user']['email'] ?? 'unknown') . " logged out successfully."
        );
        header('Location: ' . url('login'));
        exit;
    }
}
