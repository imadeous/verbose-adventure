<h1 class="text-3xl font-extrabold mb-6 text-gray-800">Category Details</h1>
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="mb-2">
        <span class="font-semibold text-gray-700">Name:</span>
        <span class="text-gray-900"><?= e($category->name) ?></span>
    </div>
    <div class="mb-2">
        <span class="font-semibold text-gray-700">ID:</span>
        <span class="text-gray-900"><?= e($category->id) ?></span>
    </div>
    <div>
        <span class="font-semibold text-gray-700">Created At:</span>
        <span class="text-gray-900"><?= e($category->created_at) ?></span>
    </div>
</div>

<div class="flex space-x-3 mb-8">
    <a href="<?= url('admin/categories/' . $category->id . '/edit') ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Edit</a>
    <a href="<?= url('admin/categories') ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Back to List</a>
</div>
<?= var_dump($products) ?>

<h2 class="text-2xl font-bold mb-4 text-gray-800">Products in this Category</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">ID</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Name</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Price</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr class="border-t">
                        <td class="px-4 py-2"><?= e($product->id) ?></td>
                        <td class="px-4 py-2"><?= e($product->name) ?></td>
                        <td class="px-4 py-2"><?= e($product->price) ?></td>
                        <td class="px-4 py-2"><?= e($product->created_at) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">No products found in this category.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>