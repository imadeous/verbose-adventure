<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="<?= url('admin/categories/create') ?>" class="btn btn-primary">Add Category</a>
</div>
<div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl text-sm">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Name</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                    <td class="px-4 py-2 whitespace-nowrap text-blue-900 font-semibold"><?= e($category->name) ?></td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="<?= url('admin/categories/' . $category->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">View</a>
                            <a href="<?= url('admin/categories/' . $category->id . '/edit') ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">Edit</a>
                            <form action="<?= url('admin/categories/' . $category->id . '/delete') ?>" method="POST" class="inline">
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs" onclick="return confirm('Delete this category?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>