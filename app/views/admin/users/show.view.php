<?php view()->layout('admin'); ?>

<?php

use Core\Controller;

Controller::start('title'); ?>
User Details: <?= e($user->username) ?>
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="bg-white p-4 md:p-6 rounded-lg shadow-md mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">User Details: <span class="font-normal text-gray-600"><?= e($user->username) ?></span></h1>
        <a href="<?= url('admin/users') ?>" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 font-semibold text-xs rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Users
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">ID</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= $user->id ?></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">Username</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= e($user->username) ?></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">Email</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= e($user->email) ?></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">Role</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= e(ucfirst($user->role)) ?></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">Created At</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= $user->created_at ? date('F j, Y, g:i a', strtotime($user->created_at)) : 'N/A' ?></p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
            <p class="mt-1 text-lg font-semibold text-gray-900"><?= $user->updated_at ? date('F j, Y, g:i a', strtotime($user->updated_at)) : 'N/A' ?></p>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end items-center space-x-2">
        <a href="<?= url('admin/users/edit/' . $user->id) ?>" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold text-sm rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors" title="Edit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
            </svg>
            Edit User
        </a>
        <form action="<?= url('admin/users/destroy/' . $user->id) ?>" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');" class="inline-flex">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="<?= Core\Csrf::generate() ?>">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors" title="Delete">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete User
            </button>
        </form>
    </div>
</div>
<?php Controller::end(); ?>