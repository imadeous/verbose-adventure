<?php

use Core\Controller;

Controller::start('title');
?>
<?= e($title) ?>
<?php
Controller::end();
Controller::start('content');
?>
<div class="container mx-auto max-w-md p-4">
    <h1 class="text-2xl font-bold mb-4">Login</h1>

    <?php if (session()->has('error')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->get('error') ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= url('login') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select the first form on the page, which is our login form.
        const loginForm = document.querySelector('form');

        if (loginForm) {
            loginForm.addEventListener('submit', function(event) {
                const email = document.getElementById('email').value;
                // For security, we log the password's length, not the password itself.
                const passwordLength = document.getElementById('password').value.length;

                console.log('--- Frontend Login Debug ---');
                console.log('Form is being submitted.');
                console.log('Email value:', email);
                console.log('Password length:', passwordLength);
                console.log('CSRF Token value:', document.querySelector('input[name="_token"]').value);
                console.log('----------------------------');
            });
        }
    });
</script>

<?php Controller::end(); ?>