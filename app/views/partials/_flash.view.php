<?php

if (session()->has('success')) : ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-5 right-5 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg z-50" role="alert">
        <p class="font-bold">Success</p>
        <p><?= session()->flash('success') ?></p>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-5 right-5 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg z-50" role="alert">
        <p class="font-bold">Error</p>
        <p><?= session()->flash('error') ?></p>
    </div>
<?php endif; ?>

<?php if (session()->has('info')) : ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-5 right-5 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-lg z-50" role="alert">
        <p class="font-bold">Info</p>
        <p><?= session()->flash('info') ?></p>
    </div>
<?php endif; ?>