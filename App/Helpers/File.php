<?php

namespace App\Helpers;

class File
{
    /**
     * Upload a file to the given directory.
     *
     * @param array $file The $_FILES['input'] array
     * @param string $targetDir The directory to upload to (absolute or relative to public/)
     * @param array $options Optional: ['allowed_types' => [], 'max_size' => int (bytes), 'new_name' => string]
     * @return array [success => bool, 'path' => string|null, 'error' => string|null]
     */
    public static function upload($file, $targetDir, $options = [])
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'path' => null, 'error' => 'No file uploaded.'];
        }
        $allowed = $options['allowed_types'] ?? [];
        $maxSize = $options['max_size'] ?? null;
        $newName = $options['new_name'] ?? null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($allowed && !in_array($ext, $allowed)) {
            return ['success' => false, 'path' => null, 'error' => 'File type not allowed.'];
        }
        if ($maxSize && $file['size'] > $maxSize) {
            return ['success' => false, 'path' => null, 'error' => 'File too large.'];
        }

        // Determine the base directory (relative to project root, not public/)
        // Since this runs from public/index.php, we need to go up one level
        $baseDir = __DIR__ . '/../../public/storage';
        $targetDir = ltrim($targetDir, '/\\');
        $dir = $targetDir ? $baseDir . '/' . $targetDir : $baseDir;

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $filename = $newName ? $newName . '.' . $ext : uniqid('file_', true) . '.' . $ext;
        $dest = $dir . DIRECTORY_SEPARATOR . $filename;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            // Return web-accessible path (normalize slashes and make relative to public/)
            $relativePath = 'storage/' . ($targetDir ? $targetDir . '/' : '') . $filename;
            $webPath = str_replace('\\', '/', $relativePath);
            return ['success' => true, 'path' => $webPath, 'error' => null];
        }
        return ['success' => false, 'path' => null, 'error' => 'Failed to move uploaded file.'];
    }

    /**
     * Load a file's contents.
     *
     * @param string $path
     * @return string|false
     */
    public static function load($path)
    {
        if (!file_exists($path)) {
            return false;
        }
        return file_get_contents($path);
    }

    /**
     * Delete a file by path.
     *
     * @param string $path
     * @return bool True if deleted, false otherwise
     */
    public static function delete($path)
    {
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
}
