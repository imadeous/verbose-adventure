<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js" defer></script>
    <link rel="stylesheet" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/css/scroll.css">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="bg-gray-900">
    <?php include_once __DIR__ . '/../partials/_flash.view.php'; ?>

    <div x-data="{sidebar : (window.innerWidth > 768) ?? true }" class="flex min-h-screen sm:relative">
        <?php include_once __DIR__ . '/../partials/admin-sidebar.php'; ?>

        <main class="flex-1 flex flex-col h-screen bg-gray-100 overflow-y-scroll scrollbar">

            <div class="sticky top-0 z-40">
                <?php include_once __DIR__ . '/../partials/admin-header.php'; ?>
            </div>
            <!-- End of Sticky header -->
            <div class="p-4 lg:p-6 space-y-8 flex-1">
                <?php Core\Controller::yield('content'); ?>
            </div>
            <div class="flex justify-end text-gray-400 px-8 mb-4">
                Developed by @Imadeous
            </div>
        </main>
    </div>

</body>

</html>