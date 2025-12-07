<div class="max-w-4xl mx-auto p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Add Product Variant</h1>
        <p class="text-gray-600 mt-2">for <span class="font-semibold"><?= e($product->name) ?></span></p>
    </div>

    <form action="<?= url('admin/products/' . $product->id . '/variants') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-blue-900 mb-6">Variant Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dimensions -->
                <div>
                    <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">
                        Dimensions
                    </label>
                    <input type="text"
                        name="dimensions"
                        id="dimensions"
                        placeholder="e.g., 2x3x8 cm, 8&quot; wingspan, 6&quot; tall"
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                    <p class="text-xs text-gray-500 mt-1">Any user-defined measurement format</p>
                </div>

                <!-- Weight -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">
                        Weight (grams)
                    </label>
                    <input type="number"
                        name="weight"
                        id="weight"
                        min="0"
                        placeholder="e.g., 150"
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                    <p class="text-xs text-gray-500 mt-1">Weight in grams only</p>
                </div>

                <!-- Material -->
                <div>
                    <label for="material" class="block text-sm font-medium text-gray-700 mb-1">
                        Material
                    </label>
                    <input type="text"
                        name="material"
                        id="material"
                        placeholder="e.g., PLA, Resin, Wood, etc."
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                </div>

                <!-- Color with Picker -->
                <div x-data="{ colorValue: '#000000' }">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                        Color
                    </label>
                    <div class="flex items-center space-x-3">
                        <input type="color"
                            x-model="colorValue"
                            @input="$refs.colorHex.value = colorValue"
                            class="h-10 w-16 rounded border border-blue-300 cursor-pointer">
                        <input type="text"
                            name="color"
                            id="color"
                            x-ref="colorHex"
                            x-model="colorValue"
                            placeholder="#000000"
                            pattern="^#[0-9A-Fa-f]{6}$"
                            class="flex-1 rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Select from picker or enter hex code</p>
                </div>

                <!-- Finishing -->
                <div>
                    <label for="finishing" class="block text-sm font-medium text-gray-700 mb-1">
                        Finishing
                    </label>
                    <input type="text"
                        name="finishing"
                        id="finishing"
                        placeholder="e.g., raw print, sanded, painted"
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                    <p class="text-xs text-gray-500 mt-1">e.g., raw print, sanded, painted, full post production</p>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                        Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                        <input type="number"
                            name="price"
                            id="price"
                            step="0.01"
                            min="0"
                            required
                            placeholder="0.00"
                            class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 pl-8 pr-4 py-2 text-gray-900 bg-blue-50 transition">
                    </div>
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                        SKU (optional)
                    </label>
                    <input type="text"
                        name="sku"
                        id="sku"
                        placeholder="e.g., PROD-001-BLK-SM"
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                        Stock Quantity
                    </label>
                    <input type="number"
                        name="stock_quantity"
                        id="stock_quantity"
                        min="0"
                        value="0"
                        class="w-full rounded-lg border border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 px-4 py-2 text-gray-900 bg-blue-50 transition">
                </div>
            </div>

            <!-- Assembly Required -->
            <div class="mt-6">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox"
                        name="assembly_required"
                        id="assembly_required"
                        value="1"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5">
                    <span class="text-sm font-medium text-gray-700">Assembly Required</span>
                </label>
                <p class="text-xs text-gray-500 ml-8 mt-1">Check if this variant requires assembly by the customer</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-md p-6">
            <a href="<?= url('admin/products/' . $product->id) ?>"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
                Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                Add Variant
            </button>
        </div>
    </form>
</div>