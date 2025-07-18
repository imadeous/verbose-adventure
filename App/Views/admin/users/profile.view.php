<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white rounded-xl shadow-md p-8 border border-blue-100 flex flex-col items-center">
        <div class="mb-4">
            <img src="" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-blue-200 shadow">
        </div>
        <h2 class="text-2xl font-bold text-blue-900 mb-1"><?= htmlspecialchars($user->name ?? $user->username ?? 'User') ?></h2>
        <div class="text-sm text-blue-500 mb-2">@<?= htmlspecialchars($user->username ?? '') ?></div>
        <div class="flex flex-col gap-2 w-full max-w-xs mt-4">
            <div class="flex items-center justify-between">
                <span class="text-gray-500">Email:</span>
                <span class="font-medium text-blue-900"><?= htmlspecialchars($user->email ?? '-') ?></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-500">Role:</span>
                <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs uppercase font-semibold tracking-wide">
                    <?= htmlspecialchars($user->role ?? '-') ?>
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-500">Joined:</span>
                <span class="text-blue-700 font-medium">
                    <?= $user && $user->created_at ? date('F j, Y', strtotime($user->created_at)) : '-' ?>
                </span>
            </div>
        </div>
        <div class="mt-8">
            <a href="<?= url('admin/users/' . $user->id . '/edit') ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Edit Profile</a>
        </div>
    </div>
</div>