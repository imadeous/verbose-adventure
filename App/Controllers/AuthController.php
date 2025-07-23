<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;

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
        if (empty($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
            flash('error', 'Invalid CSRF token.');
            $this->view('auth/login');
            return;
        }
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if (empty($email) || empty($password)) {
            flash('error', 'Email and password are required.');
            $this->view('auth/login');
            return;
        }
        // Use new query builder syntax to find user by email
        $userRow = User::query()
            ->where('email', '=', $email)
            ->limit(1)
            ->get();
        $user = !empty($userRow) ? new User($userRow[0]) : null;
        var_dump($user);
        if ($user && password_verify($password, $user->password)) {
            Auth::login($user->id);
            $this->redirect('/admin'); // Redirect to admin dashboard
        }
        flash('error', 'Invalid credentials.');
        $this->view('auth/login');
    }

    public function logout()
    {
        // CSRF check
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
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
