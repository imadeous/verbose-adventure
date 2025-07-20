<h1 class="text-2xl font-bold mb-4">Add Product</h1>
<form action="<?= url('admin/products') ?>" method="POST">
    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" class="input" required>
    </div>
    <div class="mb-4">
        <label>Category</label>
        <select name="category_id" class="input" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= e($category->id) ?>"><?= e($category->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-4">
        <label>Price</label>
        <input type="number" name="price" class="input" step="0.01">
    </div>
    <div class="mb-4">
        <label>Description</label>
        <textarea name="description" class="input"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= url('admin/products') ?>" class="btn">Cancel</a>
</form>