<h1 class="text-3xl font-extrabold text-gray-800 mb-6">Add Category</h1>
<form action="<?= url('admin/categories') ?>" method="POST" class="bg-white p-8 rounded shadow-md max-w-md mx-auto">
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-2">Name</label>
        <input type="text" name="name" class="input w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
    <div class="flex items-center space-x-4">
        <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Save</button>
        <a href="<?= url('admin/categories') ?>" class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded">Cancel</a>
    </div>
</form>