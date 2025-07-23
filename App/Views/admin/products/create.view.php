<div class="card max-w-xl mx-auto mt-8 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Add Product</h1>
    <form action="<?= url('admin/products') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        <div>
            <label for="name" class="block font-semibold mb-1">Name</label>
            <input type="text" name="name" id="name" class="input w-full" required>
        </div>
        <div>
            <label for="category_id" class="block font-semibold mb-1">Category</label>
            <select name="category_id" id="category_id" class="input w-full" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= e($category->id) ?>"><?= e($category->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="price" class="block font-semibold mb-1">Price</label>
            <input type="number" name="price" id="price" class="input w-full" step="0.01">
        </div>
        <div>
            <label for="description" class="block font-semibold mb-1">Description</label>
            <textarea name="description" id="description" class="input w-full" rows="4"></textarea>
        </div>
        <div class="flex items-center gap-3 mt-6">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= url('admin/products') ?>" class="btn">Cancel</a>
        </div>
    </form>
</div>