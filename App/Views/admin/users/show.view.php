<div class="max-w-lg mx-auto p-8">
    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-8">User Details</h1>
        <div class="mb-3 flex items-center"><span class="w-32 text-blue-700 font-semibold">ID:</span> <span class="text-blue-900 font-bold"><?= e($user->id) ?></span></div>
        <div class="mb-3 flex items-center"><span class="w-32 text-blue-700 font-semibold">Username:</span> <span class="text-blue-900"><?= e($user->username) ?></span></div>
        <div class="mb-3 flex items-center"><span class="w-32 text-blue-700 font-semibold">Email:</span> <span class="text-blue-900"><?= e($user->email) ?></span></div>
        <div class="mb-3 flex items-center"><span class="w-32 text-blue-700 font-semibold">Role:</span> <span class="text-blue-900 capitalize"><?= e($user->role) ?></span></div>
        <div class="flex gap-3 mt-8">
            <a href="<?= url('/admin/users/' . $user->id . '/edit') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Edit</a>
            <a href="<?= url('/admin/users') ?>" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-5 py-2 rounded-lg font-semibold shadow border border-blue-200 transition">Back to List</a>
        </div>
    </div>
</div>