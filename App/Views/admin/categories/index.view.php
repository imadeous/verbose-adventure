<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="<?= url('admin/categories/create') ?>" class="btn btn-primary">Add Category</a>
</div>
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($categories as $category): ?>
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap"><?= e($category->name) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?= url('admin/categories/' . $category->id) ?>" class="btn btn-xs btn-outline">View</a>
                        <a href="<?= url('admin/categories/' . $category->id . '/edit') ?>" class="btn btn-xs btn-outline">Edit</a>
                        <form action="<?= url('admin/categories/' . $category->id . '/delete') ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>