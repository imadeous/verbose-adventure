<div class="container mx-auto px-4 py-8 max-w-xl">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create User</h1>

        <?php if ($msg = flash()): ?>
            <div class="mb-4">
                <div class="px-4 py-3 rounded <?php if ($msg['type'] === 'error'): ?>bg-red-100 text-red-700 border border-red-300<?php else: ?>bg-green-100 text-green-700 border border-green-300<?php endif; ?>">
                    <?= e($msg['message']) ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?= url('/admin/users') ?>" method="POST" class="space-y-5" autocomplete="off">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Create</button>
            </div>
        </form>
    </div>
</div>