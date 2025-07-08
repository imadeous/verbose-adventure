<?php view()->layout('admin'); ?>

<?php

use Core\Controller;
use App\Helpers\Auth;

Controller::start('title'); ?>
General Settings
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="bg-white p-4 md:p-6 rounded-lg shadow-md mt-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">General Settings</h1>

    <div class="space-y-8">
        <!-- Site Analytics Feature -->
        <?php if (Auth::check() && Auth::user()->role === 'admin') : ?>
            <div class="p-6 border border-gray-200 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Site Analytics</h2>

                <?php if ($analyticsTableExists) : ?>
                    <div class="flex items-center">
                        <span class="text-green-600 font-semibold">Analytics is currently Enabled.</span>
                    </div>
                    <p class="text-gray-600 mt-2">The analytics table exists and data is being collected. To reconfigure, the feature must be reset manually.</p>
                    <?php if (!empty($config['tracked_data'])) : ?>
                        <div class="mt-4 pl-2">
                            <p class="text-sm text-gray-800 font-semibold">Currently tracking:</p>
                            <ul class="list-disc list-inside text-gray-700 mt-2">
                                <?php foreach ($config['tracked_data'] as $item) : ?>
                                    <li><?= htmlspecialchars(ucwords(str_replace('_', ' ', $item))) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div x-data="{ enabled: <?= isset($config['enabled']) && $config['enabled'] ? 'true' : 'false' ?> }">
                        <p class="text-gray-600 mb-4">Enable site analytics and configure what data to track.</p>

                        <form action="<?= url('admin/settings/analytics') ?>" method="POST">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                            <div class="space-y-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="analytics_enabled" class="form-checkbox h-5 w-5 text-blue-600" x-model="enabled">
                                    <span class="ml-2 text-gray-700">Enable Site Analytics</span>
                                </label>

                                <div x-show="enabled" class="pl-7 space-y-2" x-transition>
                                    <p class="text-sm text-gray-600">Select the data points you want to track:</p>
                                    <?php $tracked_data = $config['tracked_data'] ?? []; ?>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tracked_data[]" value="visitor_ip" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array('visitor_ip', $tracked_data) ? 'checked' : '' ?>>
                                        <span class="ml-2 text-gray-700">Visitor IP Address</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tracked_data[]" value="user_agent" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array('user_agent', $tracked_data) ? 'checked' : '' ?>>
                                        <span class="ml-2 text-gray-700">User Agent</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tracked_data[]" value="referer_url" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array('referer_url', $tracked_data) ? 'checked' : '' ?>>
                                        <span class="ml-2 text-gray-700">Referer URL</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tracked_data[]" value="country_code" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array('country_code', $tracked_data) ? 'checked' : '' ?>>
                                        <span class="ml-2 text-gray-700">Country Code</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tracked_data[]" value="device_type" class="form-checkbox h-4 w-4 text-blue-600" <?= in_array('device_type', $tracked_data) ? 'checked' : '' ?>>
                                        <span class="ml-2 text-gray-700">Device Type</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700">
                                    Save Analytics Settings
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>

            <!-- Managed Tables Settings -->
            <?php if (Auth::check() && Auth::user()->role === 'admin') : ?>
                <div x-data="{
                allTables: [],
                managedTables: [],
                isLoading: true,
                fetchTables() {
                    fetch('<?= url('api/managed-tables') ?>')
                        .then(response => response.json())
                        .then(data => {
                            this.allTables = data.all_tables;
                            this.managedTables = data.managed_tables;
                            this.isLoading = false;
                        })
                        .catch(() => {
                            this.isLoading = false;
                            // Handle error, maybe show a message
                        });
                }
            }" x-init="fetchTables()" class="p-6 border border-gray-200 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Managed Tables</h2>
                    <p class="text-gray-600 mb-4">Select which tables should be treated as managed resources, giving them dedicated sections in the admin panel.</p>

                    <div x-show="isLoading" class="text-center text-gray-500">
                        Loading tables...
                    </div>

                    <form x-show="!isLoading" action="<?= url('admin/settings/managed-tables') ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="space-y-2">
                            <template x-for="table in allTables" :key="table">
                                <label class="flex items-center">
                                    <input type="checkbox" name="managed_tables[]" :value="table" class="form-checkbox h-4 w-4 text-blue-600" :checked="managedTables.includes(table)">
                                    <span class="ml-2 text-gray-700 font-mono" x-text="table"></span>
                                </label>
                            </template>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700">
                                Save Managed Tables
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Other settings can be added here in the future -->

    </div>
</div>
<?php Controller::end(); ?>