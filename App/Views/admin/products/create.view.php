<div class="max-w-4xl mx-auto p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Add New Product</h1>
        <p class="text-gray-600 mt-2">Fill in the product details. Add images later from the Gallery page.</p>
    </div>

    <form action="<?= url('admin/products') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-4">Product Information</h2>

                <div class="space-y-4">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            name="name"
                            id="name"
                            required
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id"
                            id="category_id"
                            required
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= e($category->id) ?>"><?= e($category->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description"
                            id="description"
                            rows="6"
                            placeholder="Describe your product..."
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition resize-none"></textarea>
                    </div>

                    <!-- Note about variants -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Product Variants</p>
                                <p>After creating the product, you can add variants with specific dimensions, materials, colors, finishing options, and pricing.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Action Buttons -->
<div class="mt-8 flex items-center justify-between bg-white rounded-xl shadow-md p-6">
    <a href="<?= url('admin/products') ?>"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
        Cancel
    </a>
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
        Create Product
    </button>
</div>
</form>
</div>