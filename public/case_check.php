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
echo "\nDone listing files and folders.\n";

// --- Force rename 'Core' and 'App' folders to lowercase if needed ---
$baseDir = dirname(__DIR__);
$targets = ['Core', 'App'];
foreach ($targets as $target) {
    $oldPath = $baseDir . DIRECTORY_SEPARATOR . $target;
    $newPath = $baseDir . DIRECTORY_SEPARATOR . strtolower($target);
    if (is_dir($oldPath) && $oldPath !== $newPath) {
        // Only rename if the case is not already correct
        if (strtolower($target) !== $target) {
            echo "Renaming $oldPath to $newPath\n";
            rename($oldPath, $newPath);
        }
    }
}

// --- Force rename all subdirectories in 'app' to lowercase if needed ---
$appDir = $baseDir . DIRECTORY_SEPARATOR . 'app';
if (is_dir($appDir)) {
    $subItems = scandir($appDir);
    foreach ($subItems as $item) {
        if ($item === '.' || $item === '..') continue;
        $itemPath = $appDir . DIRECTORY_SEPARATOR . $item;
        $lowerItemPath = $appDir . DIRECTORY_SEPARATOR . strtolower($item);
        if (is_dir($itemPath) && $itemPath !== $lowerItemPath) {
            if (strtolower($item) !== $item) {
                echo "Renaming $itemPath to $lowerItemPath\n";
                rename($itemPath, $lowerItemPath);
            }
        }
    }
}
