<h1 class="text-2xl font-bold mb-4">Category Details</h1>
<div class="mb-4">
    <strong>Name:</strong> <?= e($category->name) ?><br>
    <strong>ID:</strong> <?= e($category->id) ?><br>
    <strong>Created At:</strong> <?= e($category->created_at) ?><br>
</div>
<a href="<?= url('admin/categories/' . $category->id . '/edit') ?>" class="btn btn-primary">Edit</a>
<a href="<?= url('admin/categories') ?>" class="btn">Back to List</a>