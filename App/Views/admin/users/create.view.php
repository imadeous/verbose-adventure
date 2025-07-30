<div class="max-w-xl mx-auto p-8">
    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Create User</h1>

        <?php if ($msg = flash()): ?>
            <div class="mb-4">
                <div class="px-4 py-3 rounded <?php if ($msg['type'] === 'error'): ?>bg-red-100 text-red-700 border border-red-300<?php else: ?>bg-green-100 text-green-700 border-green-300<?php endif; ?>">
                    <?= e($msg['message']) ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?= url('/admin/users') ?>" method="POST" class="space-y-5" autocomplete="off">
            <?= csrf_field() ?>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Username</label>
                <input type="text" name="username" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Role</label>
                <select name="role" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900">
                    <option value="user">Normal User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Create</button>
            </div>
        </form>
    </div>
</div>