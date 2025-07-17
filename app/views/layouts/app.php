<!DOCTYPE html>
<html lang="en" class="bg-white text-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Print3D Pro' ?></title>
    <link rel="shortcut icon" href="/assets/img/favicon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- <link rel="stylesheet" href="/assets/css/LineIcons.2.0.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js" defer></script>
    <meta name="description"
        content="Professional 3D printing services for rapid prototyping, custom manufacturing, and design consultation.">
</head>

<body class="min-h-screen flex flex-col bg-white text-gray-900">
    <!-- Navbar -->
    <?= $this->partial('/front-navbar'); ?>

    <!-- Main Content -->
    <main class="flex-1">
        <?= $this->yield('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->partial('/footer'); ?>
</body>

</html>