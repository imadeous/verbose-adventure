<h1 class="text-2xl font-bold mb-4">Edit Product</h1>
<form action="<?= url('admin/products/' . $product->id . '/update') ?>" method="POST">
    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" class="input" value="<?= e($product->name) ?>" required>
    </div>
    <div class="mb-4">
        <label>Category</label>
        <input type="text" name="category" class="input" value="<?= e($product->category) ?>">
    </div>
    <div class="mb-4">
        <label>Price</label>
        <input type="number" name="price" class="input" step="0.01" value="<?= e($product->price) ?>">
    </div>
    <div class="mb-4">
        <label>Description</label>
        <textarea name="description" class="input"><?= e($product->description) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= url('admin/products') ?>" class="btn">Cancel</a>
</form>