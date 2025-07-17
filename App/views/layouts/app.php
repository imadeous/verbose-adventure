<!DOCTYPE html>
<html lang="en" class="bg-white text-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Craftophile Shop' ?></title>
    <link rel="shortcut icon" href="/assets/img/favicon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- <link rel="stylesheet" href="/assets/css/LineIcons.2.0.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js" defer></script>
    <meta name="description"
        content="Professional 3D printing services for rapid prototyping, custom manufacturing, and design consultation.">

    <style>
        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s cubic-bezier(.4, 0, .2, 1), transform 0.7s cubic-bezier(.4, 0, .2, 1);
        }

        .scroll-animate.in-view {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-900">
    <!-- Navbar -->
    <?= $this->partial('/front-navbar'); ?>

    <!-- Main Content -->
    <main class="flex-1">
        <?= $this->yield('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->partial('/footer'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new window.IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, {
                threshold: 0.15
            });

            document.querySelectorAll('section').forEach(section => {
                section.classList.add('scroll-animate');
                observer.observe(section);
            });
        });
    </script>
</body>

</html>