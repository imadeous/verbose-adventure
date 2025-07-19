<?php
// Usage: include this partial in your layout or view
if (!isset($_SESSION)) session_start();
$flashes = $_SESSION['_flash'] ?? [];
if ($flashes):
    foreach ($flashes as $type => $msg):
        $color = [
            'error' => 'bg-red-100 text-red-700 border-red-300',
            'success' => 'bg-green-100 text-green-700 border-green-300',
            'info' => 'bg-blue-100 text-blue-700 border-blue-300',
            'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
        ][$type] ?? 'bg-gray-100 text-gray-700 border-gray-300';
?>
        <div
            class="fixed top-6 right-6 z-50 min-w-[220px] max-w-xs shadow-lg border <?= $color ?> p-3 rounded-lg flex items-center justify-between gap-2 animate-fade-in"
            x-data="{ show: true }"
            x-init="setTimeout(() => { show = false }, 4000)"
            x-show="show"
            x-transition
            @click="show = false"
            style="cursor:pointer">
            <span><?= e($msg) ?></span>
            <button type="button" class="ml-2 text-xl leading-none" @click="show = false">&times;</button>
        </div>
        <script>
            setTimeout(function() {
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'X-Flash-Clear': '1'
                    }
                });
            }, 4100);
        </script>
<?php
    endforeach;
    unset($_SESSION['_flash']);
endif;
