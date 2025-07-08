<?php

use Core\Controller; ?>

<?php Controller::start('title'); ?>
Create New Table
<?php Controller::end(); ?>

<?php Controller::start('content'); ?>
<div class="container mx-auto px-4 py-8" x-data="tableCreator()">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create New Database Table</h1>

    <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
        <form action="<?= url('/admin/tables/store') ?>" method="POST">
            <?= csrf() ?>

            <div class="mb-6">
                <label for="table_name" class="block text-gray-700 text-sm font-medium mb-2">Table Name:</label>
                <input type="text" name="table_name" id="table_name" required pattern="[a-zA-Z0-9_]+" title="Only alphanumeric characters and underscores are allowed." class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-6">
                <h3 class="text-gray-700 text-sm font-medium mb-2">Timestamps</h3>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="timestamps[]" value="created_at" checked class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">created_at</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="timestamps[]" value="updated_at" checked class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">updated_at</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="timestamps[]" value="deleted_at" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">deleted_at (for soft deletes)</span>
                    </label>
                </div>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Columns</h2>

            <div class="space-y-4">
                <template x-for="(column, index) in columns" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-4 items-center bg-gray-50 p-4 rounded-md border border-gray-200">
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 text-sm font-medium mb-1">Name</label>
                            <input type="text" :name="`columns[${index}][name]`" x-model="column.name" required pattern="[a-zA-Z0-9_]+" title="Only alphanumeric characters and underscores are allowed." class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Type</label>
                            <select :name="`columns[${index}][type]`" x-model="column.type" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option>INT</option>
                                <option>VARCHAR</option>
                                <option>TEXT</option>
                                <option>DATE</option>
                                <option>TIMESTAMP</option>
                                <option>DECIMAL</option>
                                <option>BOOLEAN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Length</label>
                            <input type="text" :name="`columns[${index}][length]`" x-model="column.length" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2 flex items-center space-x-4 pt-6">
                            <label class="flex items-center">
                                <input type="checkbox" :name="`columns[${index}][nullable]`" x-model="column.nullable" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"> <span class="ml-2 text-sm text-gray-600">Nullable</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="primary_key" :value="index" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"> <span class="ml-2 text-sm text-gray-600">Primary</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" :name="`columns[${index}][auto_increment]`" x-model="column.auto_increment" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"> <span class="ml-2 text-sm text-gray-600">A.I.</span>
                            </label>
                        </div>
                        <div class="flex items-center pt-6">
                            <button type="button" @click="removeColumn(index)" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Remove Field
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-between mt-8">
                <button type="button" @click="addColumn()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Column
                </button>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Table
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function tableCreator() {
        return {
            columns: [{
                    name: 'id',
                    type: 'INT',
                    length: '11',
                    nullable: false,
                    auto_increment: true
                },
                {
                    name: '',
                    type: 'VARCHAR',
                    length: '255',
                    nullable: false,
                    auto_increment: false
                }
            ],
            addColumn() {
                this.columns.push({
                    name: '',
                    type: 'VARCHAR',
                    length: '255',
                    nullable: false,
                    auto_increment: false
                });
            },
            removeColumn(index) {
                this.columns.splice(index, 1);
            }
        }
    }
</script>

<?php Controller::end(); ?>