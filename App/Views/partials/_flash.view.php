<?php
// Usage: include this partial in your layout or view
if (!isset($_SESSION)) session_start();
$flashes = $_SESSION['_flash'] ?? [];
if ($flashes):
    foreach ($flashes as $type => $msg):
        $color = [
            'error' => 'bg-red-100 text-red-700',
            'success' => 'bg-green-100 text-green-700',
            'info' => 'bg-blue-100 text-blue-700',
            'warning' => 'bg-yellow-100 text-yellow-700',
        ][$type] ?? 'bg-gray-100 text-gray-700';
?>
        <div class="<?= $color ?> p-2 mb-4 rounded text-center text-sm font-medium animate-fade-in">
            <?= e($msg) ?>
        </div>
<?php
    endforeach;
    unset($_SESSION['_flash']);
endif;
