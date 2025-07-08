<?php view()->layout('admin'); ?>

<?php

use Core\Controller;

Controller::start('title'); ?>
<?= htmlspecialchars($title) ?>
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="container mx-auto p-4 md:p-6">
    <div class="bg-white p-6 rounded-lg shadow-md">

        <?php
        // Check for flashed error messages
        $errors = session()->flash('errors');
        if ($errors) : ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Upload Failed</p>
                <ul class="list-disc list-inside mt-2">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row items-center">
            <!-- Avatar Display and Upload -->
            <div class="md:w-1/3 text-center">
                <?php
                $avatarUrl = (new \App\Helpers\File())->url($user->avatar);
                ?>
                <img src="<?= $avatarUrl ?>" alt="<?= htmlspecialchars($user->username) ?>'s Avatar" class="w-40 h-40 rounded-full mx-auto object-cover border-4 border-gray-200">

                <div x-data="{ uploading: false, progress: 0 }" class="mt-4">
                    <form action="<?= url('admin/profile/avatar') ?>" method="POST" enctype="multipart/form-data"
                        @submit="uploading = true; progress = 0; let formData = new FormData($el); let request = new XMLHttpRequest(); request.open('POST', $el.action); request.upload.addEventListener('progress', (e) => { progress = Math.round((e.loaded / e.total) * 100); }); $el.submit();">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <label for="avatar-upload" class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 text-white font-semibold text-sm rounded-md hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-4 2 2 4-4 2 2z" clip-rule="evenodd" />
                            </svg>
                            Change Picture
                        </label>
                        <input id="avatar-upload" type="file" name="avatar" class="hidden" onchange="this.form.submit()">
                    </form>
                    <div x-show="uploading" class="w-full bg-gray-200 rounded-full mt-2">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" :style="`width: ${progress}%`" x-text="`${progress}%`"></div>
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="md:w-2/3 md:pl-8 mt-6 md:mt-0">
                <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($user->username) ?></h1>
                <p class="text-gray-600 text-lg"><?= htmlspecialchars($user->email) ?></p>
                <span class="inline-block bg-gray-200 text-gray-800 text-sm font-semibold px-3 py-1 rounded-full mt-2"><?= htmlspecialchars(ucfirst($user->role)) ?></span>

                <div class="mt-6 border-t pt-4">
                    <a href="<?= url('admin/users/edit/' . $user->id) ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                        Edit Profile Details
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<?php Controller::end(); ?>