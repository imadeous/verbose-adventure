<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="<?= url('admin/categories/create') ?>" class="btn btn-primary">Add Category</a>
</div>
<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= e($category->name) ?></td>
                <td>
                    <a href="<?= url('admin/categories/' . $category->id) ?>" class="btn btn-xs">View</a>
                    <a href="<?= url('admin/categories/' . $category->id . '/edit') ?>" class="btn btn-xs">Edit</a>
                    <form action="<?= url('admin/categories/' . $category->id . '/delete') ?>" method="POST" style="display:inline">
                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>