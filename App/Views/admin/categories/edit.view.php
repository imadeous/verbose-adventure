<h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Category</h1>
<form action="<?= url('admin/categories/' . $category->id . '/update') ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-md">
    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
        <input
            type="text"
            name="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value="<?= e($category->name) ?>"
            required>
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Update
        </button>
        <a href="<?= url('admin/categories') ?>" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
            Cancel
        </a>
    </div>
</form>