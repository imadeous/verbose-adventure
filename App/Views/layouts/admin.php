<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Craftophile' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-900 overflow-x-hidden">
    <div x-data="{sidebar : (window.innerWidth > 768) ?? true }" class="flex min-h-screen sm:relative">
        <?php echo $this->partial('admin/sidebar'); ?>
        <main class="flex-1 flex flex-col h-screen bg-gray-100 overflow-y-scroll scrollbar">
            <?php echo $this->partial('admin/header'); ?>
            <!-- add breadcrumbs support here   -->
            <div class="flex flex-col flex-1 overflow-y-auto">
                <?php echo $this->partial('_flash.view'); ?>
                <?php include __DIR__ . '/../../partials/breadcrumb.view.php'; ?>
                <div class="p-4 sm:p-6 lg:p-12 space-y-8 mx-2 sm:mx-6 flex-1">
                    <?php echo $this->yield('content'); ?>
                </div>
                <?php echo $this->partial('admin/footer'); ?>
            </div>
        </main>
    </div>
</body>

</html>