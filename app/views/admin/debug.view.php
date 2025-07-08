<?php

use Core\Controller; ?>

<?php Controller::start('title'); ?>
Application Debug Information
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Application Debug Information</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 space-y-6">

        <div class="p-4 border rounded">
            <h2 class="text-2xl font-bold mb-2">PHP & Error Reporting</h2>
            <p><strong>display_errors:</strong> <span class="font-mono"><?= ini_get('display_errors') ? 'On' : 'Off' ?></span></p>
            <p><strong>error_reporting:</strong> <span class="font-mono"><?= error_reporting() ?> (E_ALL is <?= E_ALL ?>)</span></p>
        </div>

        <div class="p-4 border rounded">
            <h2 class="text-2xl font-bold mb-2">View Rendering</h2>
            <?php
            $viewName = 'admin/tables/create';
            $basePath = base_path();
            $viewPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $viewName);
            $fullPath = $basePath . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $viewPath . '.view.php';
            ?>
            <p><strong>View Name:</strong> <span class="font-mono"><?= e($viewName) ?></span></p>
            <p><strong>Base Path:</strong> <span class="font-mono"><?= e($basePath) ?></span></p>
            <p><strong>Calculated View Path:</strong> <span class="font-mono"><?= e($fullPath) ?></span></p>
            <p><strong>File Exists:</strong>
                <span class="font-mono font-bold <?= file_exists($fullPath) ? 'text-green-500' : 'text-red-500' ?>">
                    <?= file_exists($fullPath) ? 'Yes' : 'No' ?>
                </span>
            </p>
            <p><strong>File is Readable:</strong>
                <span class="font-mono font-bold <?= is_readable($fullPath) ? 'text-green-500' : 'text-red-500' ?>">
                    <?= is_readable($fullPath) ? 'Yes' : 'No' ?>
                </span>
            </p>
        </div>

        <div class="p-4 border rounded">
            <h2 class="text-2xl font-bold mb-2">Session</h2>
            <p><strong>Session Status:</strong> <span class="font-mono"><?= session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive' ?></span></p>
            <p><strong>Session Data:</strong></p>
            <pre class="bg-gray-100 p-2 rounded font-mono text-sm"><?= e(print_r($_SESSION, true)) ?></pre>
        </div>

        <div class="p-4 border rounded">
            <h2 class="text-2xl font-bold mb-2">Included Files (<?= count(get_included_files()) ?>)</h2>
            <div class="h-64 overflow-y-auto bg-gray-100 p-2 rounded font-mono text-sm">
                <?php foreach (get_included_files() as $file) : ?>
                    <?= e($file) ?><br>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
<?php Controller::end(); ?>