<div class="max-w-8xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-blue-900">Products</h1>
        <a href="<?= url('admin/products/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Add Product</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Category</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Price</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap font-semibold text-blue-900"><?= e($product->name) ?></td>
                        <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($product->category) ?></td>
                        <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($product->price) ?></td>
                        <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                            <a href="<?= url('admin/products/' . $product->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm">View</a>
                            <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-3 py-1 font-semibold transition shadow-sm">Edit</a>
                            <form action="<?= url('admin/products/' . $product->id . '/delete') ?>" method="POST" style="display:inline;">
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>