<?php

namespace App\Controllers\Admin;

use App\Models\User;


use Core\Controller;

class UserController extends Controller
{
    /**
     * The model class for resource route key binding.
     */
    public static $model = \App\Models\User::class;
    public function index()
    {
        $users = User::all();
        $this->view->layout('admin');
        $this->view('admin/users/index', [
            'users' => $users,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Users'],
            ],
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/users/create', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Users', 'url' => url('/admin/users')],
                ['label' => 'Create'],
            ],
        ]);
    }

    public function store()
    {
        $data = $_POST;
        // Ensure role is set to a valid value or NULL
        $validRoles = ['admin', 'user'];
        if (empty($data['role']) || !in_array($data['role'], $validRoles, true)) {
            $data['role'] = 'user'; // Default to 'user' if not set or invalid
        }
        // Hash password if present
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        // created_at is handled by DB, avatar stays null
        $user = new User($data);
        $user->save();
        header('Location: ' . url('admin/users'));
        exit;
    }

    public function show($id)
    {
        $user = User::find($id);
        $this->view->layout('admin');
        $this->view('admin/users/show', [
            'user' => $user,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Users', 'url' => url('/admin/users')],
                ['label' => $user ? $user->username : 'User'],
            ],
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->view->layout('admin');
        $this->view('admin/users/edit', [
            'user' => $user,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('/admin')],
                ['label' => 'Users', 'url' => url('/admin/users')],
                ['label' => $user ? $user->username : 'Edit'],
            ],
        ]);
    }

    public function update($id)
    {
        $user = User::find($id);
        $data = $_POST;
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        foreach ($data as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        header('Location: ' . url('admin/users/' . $id));
        exit;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        header('Location: ' . url('admin/users'));
        exit;
    }
}
