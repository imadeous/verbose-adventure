<?php
// Recursively list all files and folders with their exact case
function listFiles($dir, $prefix = '')
{
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        echo $prefix . $item;
        if (is_dir($path)) {
            echo "/ (dir)\n";
            listFiles($path, $prefix . $item . '/');
        } else {
            echo "\n";
        }
    }
}

header('Content-Type: text/plain');
echo "Listing all files and folders (case-sensitive):\n\n";
listFiles(dirname(__DIR__));
