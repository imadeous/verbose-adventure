<?php

namespace App\Helpers;

class File
{
    protected $baseDir;
    public array $errors = [];

    public function __construct()
    {
        $this->baseDir = project_root('public/storage');
        if (!is_dir($this->baseDir)) {
            if (!mkdir($this->baseDir, 0777, true) && !is_dir($this->baseDir)) {
                throw new \Exception("Failed to create storage directory: {$this->baseDir}");
            }
        }
    }

    /**
     * Upload a file from the $_FILES superglobal.
     *
     * @param array $file The file array from $_FILES (e.g., $_FILES['avatar']).
     * @param string|null $new_name Optional new name for the file (without extension).
     * @param array $allowed_types Array of allowed file extensions.
     * @param int $max_size_mb Maximum file size in megabytes.
     * @return string|false The new filename on success, false on failure.
     */
    public function upload(array $file, ?string $new_name = null, array $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'svg'], int $max_size_mb = 5)
    {
        $this->errors = [];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->getUploadErrorMessage($file['error']);
            return false;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_size = $file['size'];
        $max_size_bytes = $max_size_mb * 1024 * 1024;

        if (!in_array($extension, $allowed_types)) {
            $this->errors[] = "Invalid file type. Allowed types are: " . implode(', ', $allowed_types);
        }

        if ($file_size > $max_size_bytes) {
            $this->errors[] = "File is too large. Maximum size is {$max_size_mb}MB.";
        }

        if (!empty($this->errors)) {
            return false;
        }

        $fileName = $new_name ? $new_name . '.' . $extension : basename($file['name']);
        $targetPath = $this->path($fileName);

        // Check if the target directory is writable
        if (!is_writable($this->baseDir)) {
            $this->errors[] = 'The storage directory is not writable. Please check server permissions.';
            $this->errors[] = 'Target directory: ' . $this->baseDir;
            return false;
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Post-move verification: Check if the file actually exists.
            if (file_exists($targetPath)) {
                return $fileName; // True success
            }

            // Handle the "false positive" case where move_uploaded_file returns true but the file is not there.
            $this->errors[] = 'File move reported success, but the file is missing at the destination.';
            $this->errors[] = 'This can indicate a server configuration or permissions issue (e.g., with XAMPP).';
            $this->errors[] = 'Destination checked: ' . $targetPath;
            return false;
        }

        $this->errors[] = 'Failed to move uploaded file. This can be caused by incorrect permissions or an invalid path.';
        $this->errors[] = 'Source: ' . $file['tmp_name'];
        $this->errors[] = 'Destination: ' . $targetPath;
        return false;
    }

    private function getUploadErrorMessage(int $error_code): string
    {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            default:
                return 'Unknown upload error.';
        }
    }

    /**
     * Delete a file from storage.
     *
     * @param string $filename The name of the file to delete.
     * @return bool True on success, false on failure.
     */
    public function delete(string $filename): bool
    {
        $path = $this->path($filename);
        if ($this->exists($filename)) {
            return unlink($path);
        }
        return false;
    }

    /**
     * Get the full path to a file in storage.
     *
     * @param string $filename
     * @return string
     */
    public function path(string $filename): string
    {
        return $this->baseDir . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Get the public URL for a file in storage.
     *
     * @param string|null $filename
     * @return string
     */
    public function url(?string $filename): string
    {
        if (empty($filename) || !$this->exists($filename)) {
            return url('storage/default-avatar.svg');
        }
        return url('storage/' . $filename);
    }

    /**
     * Check if a file exists in storage.
     *
     * @param string $filename
     * @return bool
     */
    public function exists(string $filename): bool
    {
        return file_exists($this->path($filename));
    }

    /**
     * Get the contents of a file.
     *
     * @param string $filename
     * @return string|false
     */
    public function get(string $filename)
    {
        if ($this->exists($filename)) {
            return file_get_contents($this->path($filename));
        }
        return false;
    }

    /**
     * Get the size of a file.
     *
     * @param string $filename
     * @return int|false
     */
    public function size(string $filename)
    {
        if ($this->exists($filename)) {
            return filesize($this->path($filename));
        }
        return false;
    }

    /**
     * Get the MIME type of a file.
     *
     * @param string $filename
     * @return string|false
     */
    public function mimeType(string $filename)
    {
        if ($this->exists($filename)) {
            return mime_content_type($this->path($filename));
        }
        return false;
    }

    /**
     * Get the error messages.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
