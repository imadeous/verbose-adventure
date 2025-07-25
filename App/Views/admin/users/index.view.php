<div class="max-w-8xl mx-auto p-8">
    <?php

    use App\Helpers\Auth; ?>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-blue-900">Users</h1>
        <?php if (Auth::isAdmin()): ?>
            <a href="<?= url('admin/users/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Create User</a>
        <?php endif; ?>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Username & Email</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-blue-400">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-blue-900"><?= e($user->username) ?></span>
                                        <span class="text-blue-500 text-xs"><?= e($user->email) ?></span>
                                    </div>
                                    <?php if (!is_null($user->verfied_at)): ?>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-green-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($user->role) ?></td>
                            <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                                <?php if (Auth::isAdmin()): ?>
                                    <a href="<?= url('admin/users/' . $user->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <form action="<?= url('admin/users/' . $user->id . '/delete') ?>" method="POST" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Delete" onclick="return confirm('Delete this user?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>