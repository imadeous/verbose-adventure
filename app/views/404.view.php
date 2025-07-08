<?php

use Core\Controller;

Controller::start('title');
?>
Page Not Found
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">404</h1>
        <p class="text-2xl font-light text-gray-600 mt-4">Sorry, the page you are looking for could not be found.</p>
        <a href="<?= url('/') ?>" class="mt-8 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Go Home</a>
    </div>
</div>
<?php Controller::end(); ?>