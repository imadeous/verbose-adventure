<?php Core\Controller::start('content'); ?>

<div class="bg-white p-4 md:p-6 rounded-lg shadow-md mt-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Alter Table: <span class="font-mono text-blue-600"><?= htmlspecialchars($tableName) ?></span></h1>
            <p class="text-gray-600">Add or remove columns from this table.</p>
        </div>
        <a href="<?= url('admin/tables') ?>" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-700 font-semibold text-xs rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Tables
        </a>
    </div>

    <!-- Add Column Form -->
    <div class="mb-8 p-4 border border-gray-200 rounded-lg">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Add New Column</h2>
        <form action="<?= url('admin/tables/alter/add-column') ?>" method="POST">
            <input type="hidden" name="_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="table_name" value="<?= htmlspecialchars($tableName) ?>">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Column Name -->
                <div class="md:col-span-2">
                    <label for="col_name" class="block text-sm font-medium text-gray-700">Column Name</label>
                    <input type="text" name="column[name]" id="col_name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Column Type -->
                <div>
                    <label for="col_type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="column[type]" id="col_type" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option>VARCHAR</option>
                        <option>INT</option>
                        <option>TEXT</option>
                        <option>DATE</option>
                        <option>TIMESTAMP</option>
                        <option>BOOLEAN</option>
                        <option>DECIMAL</option>
                    </select>
                </div>

                <!-- Column Length -->
                <div>
                    <label for="col_length" class="block text-sm font-medium text-gray-700">Length/Values</label>
                    <input type="text" name="column[length]" id="col_length" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Nullable Checkbox -->
                <div class="flex items-end">
                    <div class="flex items-center">
                        <input id="col_nullable" name="column[nullable]" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="col_nullable" class="ml-2 block text-sm text-gray-900">Nullable</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Column
                </button>
            </div>
        </form>
    </div>

    <!-- Existing Columns -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Existing Columns</h2>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nullable</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($columns as $column): ?>
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-mono text-gray-800"><?= htmlspecialchars($column->Field) ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($column->Type) ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600"><?= $column->Null === 'YES' ? 'Yes' : 'No' ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-yellow-600"><?= htmlspecialchars($column->Key) ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($column->Default ?? 'NULL') ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="<?= url('admin/tables/alter/drop-column') ?>" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this column? This action cannot be undone.');" class="inline-flex">
                                            <input type="hidden" name="_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="table_name" value="<?= htmlspecialchars($tableName) ?>">
                                            <input type="hidden" name="column_name" value="<?= htmlspecialchars($column->Field) ?>">
                                            <button type="submit" class="p-1 rounded-md text-red-600 hover:bg-red-100 hover:text-red-800 transition-colors" title="Drop Column">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Core\Controller::end(); ?>