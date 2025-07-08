<?php

namespace App\Controllers\Admin;

use App\Helpers\Auth;
use App\Helpers\Breadcrumb;
use App\Helpers\File;
use App\Models\User;
use Core\Controller;
use Core\Request;
use Core\Csrf;

class UserController extends Controller
{
    public function __construct()
    {
        $this->setLayout('admin');
        $this->middleware('AuthMiddleware')->only(
            [
                'index',
                'create',
                'store',
                'profile',
                'show',
                'edit',
                'update',
                'updateAvatar',
                'destroy'
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Breadcrumb::add('Users');
        $users = User::all();
        return $this->view('admin/users/index', [
            'users' => $users,
            'title' => 'Users'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Breadcrumb::add([
            ['label' => 'Users', 'url' => 'admin/users'],
            ['label' => 'Create']
        ]);
        return $this->view('admin/users/create', [
            'title' => 'Create New User'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        Csrf::check();

        $user = new User();
        $user->username = Request::input('username');
        $user->email = Request::input('email');
        $user->password = Request::input('password');
        $user->role = Request::input('role');
        $user->save();

        session()->set('success', 'User created successfully.');
        redirect('admin/users');
    }

    /**
     * Show the currently logged-in user's profile.
     */
    public function profile()
    {
        Breadcrumb::add('Profile');
        $user = Auth::user();

        if (!$user) {
            // This can happen if the user is not logged in, middleware should prevent this.
            session()->set('error', 'You must be logged in to view this page.');
            redirect('login');
            return;
        }

        return $this->view('admin/users/profile', [
            'user' => $user,
            'title' => 'My Profile'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = User::find($id);
        Breadcrumb::add([
            ['label' => 'Users', 'url' => 'admin/users'],
            ['label' => $user->username]
        ]);

        if (!$user) {
            session()->set('error', 'User not found.');
            redirect('admin/users');
            return; // Add return to stop execution
        }

        return $this->view('admin/users/show', [
            'user' => $user,
            'title' => 'View User: ' . $user->username
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $user = User::find($id);
        Breadcrumb::add([
            ['label' => 'Users', 'url' => 'admin/users'],
            ['label' => $user->username, 'url' => 'admin/users/show/' . $id],
            ['label' => 'Edit']
        ]);

        if (!$user) {
            session()->set('error', 'User not found.');
            redirect('admin/users');
            return; // Add return to stop execution
        }

        return $this->view('admin/users/edit', [
            'user' => $user,
            'title' => 'Edit User: ' . $user->username
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id)
    {
        Csrf::check();

        $user = User::find($id);
        if (!$user) {
            session()->set('error', 'User not found.');
            redirect('admin/users');
            return;
        }

        $user->username = Request::input('username');
        $user->email = Request::input('email');
        if (Request::input('password')) {
            $user->password = Request::input('password');
        }
        $user->role = Request::input('role');
        $user->save();

        session()->set('success', 'User updated successfully.');
        redirect('admin/users/show/' . $id);
    }

    public function updateAvatar()
    {
        Csrf::check();

        $user = Auth::user();

        if (!$user) {
            session()->set('error', 'User not found.');
            redirect('admin/profile');
            return;
        }

        if (isset($_FILES['avatar'])) {
            $fileHelper = new File();

            // Upload new avatar
            $newFileName = 'user_' . $user->id . '_' . time();
            $uploadedFile = $fileHelper->upload($_FILES['avatar'], $newFileName);

            if ($uploadedFile) {
                // Delete old avatar if it exists and is not the default one
                if ($user->avatar && $user->avatar !== 'default-avatar.svg' && $fileHelper->exists($user->avatar)) {
                    $fileHelper->delete($user->avatar);
                }

                $user->avatar = $uploadedFile;
                $user->save();
                session()->set('success', 'Profile picture updated successfully.');
            } else {
                // Store detailed errors in session to be displayed
                session()->flashErrors($fileHelper->getErrors());
            }
        } else {
            session()->set('error', 'No file was selected for upload.');
        }

        redirect('admin/profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Csrf::check();

        $user = User::find($id);

        if ($user) {
            // Delete avatar file if it exists
            if ($user->avatar) {
                $fileHelper = new File();
                if ($fileHelper->exists($user->avatar)) {
                    $fileHelper->delete($user->avatar);
                }
            }

            $user->delete();
            session()->set('success', 'User deleted successfully.');
        } else {
            session()->set('error', 'User not found.');
        }

        redirect('admin/users');
    }
}
