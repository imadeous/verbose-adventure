<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Helpers\Auth;

class AuthController extends Controller
{
    // Show initial setup page if no users exist
    public function setup()
    {
        if (User::query()->count() > 0) {
            header('Location: ' . url('login'));
            exit;
        }
        require __DIR__ . '/../Views/config/setup.view.php';
    }

    // Handle initial admin creation
    public function storeSetup()
    {
        if (User::query()->count() > 0) {
            flash('error', 'Setup already completed. Please log in.');
            header('Location: ' . url('login'));
            exit;
        }
        $data = $_POST;
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            flash('error', 'All fields are required.');
            header('Location: ' . url('setup'));
            exit;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            flash('error', 'Invalid email address.');
            header('Location: ' . url('setup'));
            exit;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role'] = 'admin';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['avatar'] = null;
        $user = new User($data);
        $user->save();
        flash('success', 'Admin account created! You can now log in.');
        header('Location: ' . url('login'));
        exit;
    }

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
        if ($user && password_verify($password, $user->password)) {
            Auth::login($user->id);
            flash('success', 'Welcome back!');
            header('Location: ' . url('admin'));
            exit;
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
