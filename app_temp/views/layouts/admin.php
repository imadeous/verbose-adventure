<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Sidebar Toggle' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js" defer></script>
    <link rel="stylesheet" href="/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/assets/css/scroll.css">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-900">
    <div x-data="{sidebar : (window.innerWidth > 768) ?? true }" class="flex min-h-screen sm:relative">
        <?php echo $this->partial('admin/sidebar'); ?>
        <main class="flex-1 flex flex-col h-screen bg-gray-100 overflow-y-scroll scrollbar">
            <?php echo $this->partial('admin/header'); ?>
            <?php echo $this->partial('breadcrumb.view'); ?>
            <?php echo $this->partial('_flash.view'); ?>
            <div class="p-6 lg:p-12 space-y-8 flex-1">
                <?= $content ?>
            </div>
            <?php echo $this->partial('admin/footer'); ?>
        </main>
    </div>
</body>

</html>