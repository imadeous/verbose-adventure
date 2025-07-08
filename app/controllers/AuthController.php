<?php

namespace App\Controllers;

use Core\Controller;
use App\Helpers\Auth;
use App\Models\User; // Import the User model
use Core\Request;
use Core\Csrf;
use Core\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->setLayout('app');
    }

    public function login()
    {
        return $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function attempt()
    {
        Csrf::check();

        $validator = new Validator();
        $errors = $validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!empty($errors)) {
            session()->flashErrors($errors);
            session()->set('old', ['email' => Request::post('email')]);
            redirect('login');
            return;
        }

        // --- Start of new, simplified logic ---
        $user = User::where('email', '=', Request::post('email'))->first();

        // For debugging, let's separate the user found and password verification checks.
        if (!$user) {
            // User with the given email was not found
            error_log("Login Fail: No user found for email -> " . Request::post('email'));
            session()->set('error', 'No account found for that email.');
            session()->set('old', ['email' => Request::post('email')]);
            redirect('login');
            return;
        }

        if (password_verify(trim(Request::post('password')), $user->password)) {
            // Password is correct, log the user in
            Auth::login($user);
            session()->set('success', 'You have been successfully logged in.');
            redirect('admin');
            return;
        }

        // User was found, but the password was incorrect.
        error_log("Login Fail: Invalid password for user -> " . Request::post('email'));
        session()->set('error', 'Incorrect password. Please try again.');
        session()->set('old', ['email' => Request::post('email')]);
        redirect('login');
    }

    public function logout()
    {
        Auth::logout();
        session()->set('success', 'You have been successfully logged out.');
        redirect('login');
    }
}
