<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Products</h1>
    <a href="<?= url('admin/products/create') ?>" class="btn btn-primary">Add Product</a>
</div>
<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= e($product->name) ?></td>
                <td><?= e($product->category) ?></td>
                <td><?= e($product->price) ?></td>
                <td>
                    <a href="<?= url('admin/products/' . $product->id) ?>" class="btn btn-xs">View</a>
                    <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="btn btn-xs">Edit</a>
                    <form action="<?= url('admin/products/' . $product->id . '/delete') ?>" method="POST" style="display:inline">
                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>