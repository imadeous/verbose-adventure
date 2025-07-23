<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-6">Edit Product</h1>
    <form action="<?= url('admin/products/' . $product->id) ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="POST">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" value="<?= e($product->name) ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= e($cat['id']) ?>" <?= $product->category_id == $cat['id'] ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input type="number" name="price" step="0.01" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" value="<?= e($product->price) ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" rows="4"><?= e($product->description) ?></textarea>
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">Update</button>
            <a href="<?= url('admin/products') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>