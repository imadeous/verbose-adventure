<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Craftophile' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .scrollbar::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            .scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
            }
            .scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            .scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        }
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
            <?php if (isset($breadcrumb)): ?>
                <?php echo $this->partial('breadcrumb.view', ['breadcrumb' => $breadcrumb]); ?>
            <?php endif; ?>
            <div class="flex flex-col flex-1 overflow-y-auto">
                <?php echo $this->partial('_flash.view'); ?>
                <div class="p-4 sm:p-6 lg:p-12 space-y-8 mx-2 sm:mx-6 flex-1">
                    <?php echo $this->yield('content'); ?>
                </div>
                <?php echo $this->partial('admin/footer'); ?>
            </div>
        </main>
    </div>
</body>

</html>