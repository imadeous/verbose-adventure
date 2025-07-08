<?php
$route = Core\Request::uri();

function is_active($path, $route, $isDropdown = false)
{
    // Check if the current route starts with the given path
    $isActive = strpos($route, $path) === 0;

    // For dropdowns, we want the parent to be active if any child is active.
    if ($isDropdown) {
        // Exact match or parent directory match
        return $isActive;
    }

    // For regular links, we want an exact match to avoid highlighting parent links.
    // e.g., when on `admin/tables/create`, `admin/tables` should not be active.
    if ($isActive && $route !== $path) {
        return 'hover:text-white';
    }

    if ($isActive) {
        return 'text-white bg-gray-800';
    }

    return 'hover:text-white';
}
?>
<aside x-show="sidebar" class="h-screen z-50 bg-gray-900 lg:w-72 absolute md:relative inset-0 py-2" x-cloak
    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
    <div class="flex flex-col h-full">
        <div class="flex justify-between items-center mb-4 px-3">
            <div class="">
                <a href="<?= url('/') ?>"
                    class="uppercase text-xl text-gray-300 tracking-tight font-bold px-3">Dashboard</a>
            </div>
            <button @click="sidebar = false" class="lg:hidden text-gray-100 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col justify-between h-full px-3">
            <div class="text-gray-400 tracking-wide font-medium">
                <ul class="space-y-1">
                    <li>
                        <a href="<?= url('admin') ?>" class="flex items-center space-x-2 <?= is_active('admin', $route) ?> rounded px-4 py-2 w-full">
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li x-data="{ open: <?= is_active('admin/tables', $route, true) ? 'true' : 'false' ?> }">
                        <button @click="open = !open" class="w-full flex items-center justify-between <?= is_active('admin/tables', $route, true) ? 'text-white' : '' ?> hover:text-white rounded px-4 py-2">
                            <span class="flex items-center space-x-2">
                                <span>Tables</span>
                            </span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="pl-8 space-y-1 text-sm">
                            <li>
                                <a href="<?= url('admin/tables') ?>" class="w-full block <?= is_active('admin/tables', $route) ?> rounded px-4 py-1.5">View All</a>
                            </li>
                            <li>
                                <a href="<?= url('admin/tables/create') ?>" class="w-full block <?= is_active('admin/tables/create', $route) ?> rounded px-4 py-1.5">Create New</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="text-gray-400 tracking-wide font-medium mt-6" x-data="{
                    managedTables: [],
                    currentRoute: '<?= $route ?>',
                    isActive(path) {
                        // Exact match
                        if (this.currentRoute === path) {
                            return 'text-white bg-gray-800';
                        }
                        // Check if the current route is a sub-route (e.g., /admin/users/create)
                        if (this.currentRoute.startsWith(path + '/')) {
                            return 'text-white'; // Parent is active, but not highlighted as strongly
                        }
                        return 'hover:text-white';
                    },
                    init() {
                        fetch('<?= url("api/managed-tables") ?>')
                            .then(res => res.json())
                            .then(data => {
                                this.managedTables = data.managed_tables;
                            })
                            .catch(error => console.error('Error fetching managed tables:', error));
                    }
                }">
                    <div class="px-4 pb-1 text-xs uppercase text-gray-500 tracking-wider">
                        <span>Resources</span>
                    </div>
                    <ul class="space-y-1">
                        <template x-for="table in managedTables" :key="table">
                            <li>
                                <a :href="'<?= url('admin') ?>/' + table" class="w-full flex items-center space-x-2 rounded px-4 py-2" :class="isActive('<?= url('admin') ?>/' + table)">
                                    <span x-text="table.charAt(0).toUpperCase() + table.slice(1)"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>


            <div class="text-gray-400 tracking-wide font-medium">
                <div class="mt-4">
                    <div class="px-4 pb-1 text-xs uppercase text-gray-500 tracking-wider">
                        <span>Quick Links</span>
                    </div>
                    <ul class="space-y-1">
                        <?php
                        try {
                            $db = \Core\App::get('database');
                            $statement = $db->raw("SHOW TABLES LIKE 'site_analytics'");
                            $analyticsTableExists = $statement->fetch(); // fetch() returns false if no rows
                        } catch (\Exception $e) {
                            $analyticsTableExists = false; // Suppress errors
                        }

                        if ($analyticsTableExists) {
                        ?>
                            <li>
                                <a href="<?= url('admin/settings/analytics') ?>" class="flex items-center space-x-2 <?= is_active('admin/settings/analytics', $route) ?> rounded px-4 py-2 w-full">
                                    <span>Site Analytics</span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li>
                            <a href="<?= url('admin/settings') ?>" class="flex items-center space-x-2 <?= is_active('admin/settings', $route) ?> rounded px-4 py-2 w-full">
                                <span>General Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>