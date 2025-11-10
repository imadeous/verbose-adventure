<div class="max-w-2xl mx-auto p-8">
    <div class="bg-linear-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg border border-blue-200 p-0 overflow-hidden">
        <div class="flex flex-col md:flex-row items-center gap-0 md:gap-8">
            <!-- Avatar and Basic Info -->
            <div class="flex flex-col items-center bg-blue-200/40 p-8 md:p-10 w-full md:w-1/3">
                <div class="mb-4">
                    <img src="<?= e($user->avatar ?? '/public/storage/default-avatar.svg') ?>" alt="Avatar" class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg object-cover bg-white">
                </div>
                <h2 class="text-2xl font-extrabold text-blue-900 mb-1 text-center"><?= htmlspecialchars($user->name ?? $user->username ?? 'User') ?></h2>
                <div class="text-base text-blue-500 mb-2 text-center">@<?= htmlspecialchars($user->username ?? '') ?></div>
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs uppercase font-semibold tracking-wide mb-2">
                    <?= htmlspecialchars($user->role ?? '-') ?>
                </span>
            </div>
            <!-- Details -->
            <div class="flex-1 flex flex-col justify-center p-8 md:p-10">
                <div class="flex flex-col gap-4 w-full">
                    <div class="flex items-center gap-3">
                        <span class="text-blue-700 font-semibold w-24">Email:</span>
                        <span class="font-medium text-blue-900 break-all"><?= htmlspecialchars($user->email ?? '-') ?></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-blue-700 font-semibold w-24">Joined:</span>
                        <span class="text-blue-700 font-medium">
                            <?= $user && $user->created_at ? date('F j, Y', strtotime($user->created_at)) : '-' ?>
                        </span>
                    </div>
                </div>
                <div class="mt-10 flex justify-end">
                    <a href="<?= url('admin/users/' . $user->id . '/edit') ?>" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow border border-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>