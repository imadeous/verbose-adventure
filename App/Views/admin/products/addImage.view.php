<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-6">Add Product Image</h1>
    <form action="<?= url('admin/products/' . $product->id . '/addImage') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Image</label>
            <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-blue-300 px-4 py-2 bg-blue-50">
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">Upload</button>
            <a href="<?= url('admin/products/' . $product->id) ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg">Cancel</a>
        </div>
    </form>
</div>