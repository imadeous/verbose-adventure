<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-6">Add Product</h1>
    <form action="<?= url('admin/products') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" required>
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" id="category_id" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= e($category->id) ?>"><?= e($category->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input type="number" name="price" id="price" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" step="0.01">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50" rows="4"></textarea>
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">Save</button>
            <a href="<?= url('admin/products') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>