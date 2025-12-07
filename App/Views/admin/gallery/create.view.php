<div class="max-w-2xl mx-auto overflow-x-hidden">
    <div
        x-data='galleryForm(<?= json_encode($categories) ?>, <?= json_encode($products) ?>)'
        class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Add Gallery Image</h1>
        <form class="space-y-6" autocomplete="off" method="POST" action="<?= url('admin/gallery') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Image Upload Section -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Left Column: Image Preview -->
                <div class="flex-1">
                    <label class="block text-gray-700 font-semibold mb-2">Image Preview</label>
                    <label class="block cursor-pointer group w-full">
                        <img
                            :src="imageUrl"
                            alt="Select Image"
                            class="rounded-lg border-2 border-gray-200 shadow w-full h-64 object-cover transition hover:border-blue-400"
                            @click="$refs.fileInput.click()">
                    </label>
                    <input
                        type="file"
                        name="image"
                        class="hidden"
                        required
                        accept="image/*"
                        @change="onFileChange"
                        x-ref="fileInput">
                    <p class="text-xs text-gray-500 mt-2">Click image to select file (Max 5MB)</p>
                </div>

                <!-- Right Column: Image Info -->
                <div class="flex-1 flex flex-col justify-center">
                    <template x-if="imageFile">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 text-gray-900 text-sm space-y-2">
                            <div><span class="font-semibold">Name:</span> <span x-text="imageFile.name" class="break-all"></span></div>
                            <div>
                                <span class="font-semibold">Size:</span>
                                <span :class="imageFile.size > 5 * 1024 * 1024 ? 'text-red-600 font-bold' : 'text-green-600'" x-text="(imageFile.size/1024/1024).toFixed(2) + ' MB'"></span>
                            </div>
                            <div><span class="font-semibold">Type:</span> <span x-text="imageFile.type"></span></div>
                        </div>
                    </template>
                    <template x-if="!imageFile">
                        <div class="text-gray-400 italic text-center py-8">No image selected</div>
                    </template>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="title"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    x-model="title"
                    placeholder="Enter image title"
                    required>
            </div>

            <!-- Caption -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Caption</label>
                <textarea
                    name="caption"
                    rows="2"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Optional caption or description"></textarea>
            </div>

            <!-- Image Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Image Type <span class="text-red-500">*</span></label>
                <select
                    name="image_type"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    x-model="type"
                    required>
                    <option value="">Select Type</option>
                    <option value="site">Site</option>
                    <option value="category">Category</option>
                    <option value="product">Product</option>
                    <option value="variant">Variant</option>
                </select>
            </div>

            <!-- Related Category -->
            <div x-show="type === 'category'" x-transition>
                <label class="block text-gray-700 font-semibold mb-2">Select Category <span class="text-red-500">*</span></label>
                <select
                    name="related_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    x-model="relatedId"
                    :required="type === 'category'">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category->id) ?>"><?= e($category->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Related Product -->
            <div x-show="type === 'product'" x-transition>
                <label class="block text-gray-700 font-semibold mb-2">Select Product <span class="text-red-500">*</span></label>
                <select
                    name="related_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    x-model="relatedId"
                    :required="type === 'product'">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= e($product->id) ?>"><?= e($product->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Variant Selection (Product -> Variant cascade) -->
            <div x-show="type === 'variant'" x-transition>
                <label class="block text-gray-700 font-semibold mb-2">Select Product <span class="text-red-500">*</span></label>
                <select
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-4"
                    x-model="selectedProduct"
                    @change="loadVariants()"
                    :required="type === 'variant'">
                    <option value="">Select Product First</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= e($product->id) ?>"><?= e($product->name) ?></option>
                    <?php endforeach; ?>
                </select>

                <template x-if="selectedProduct">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Select Variant <span class="text-red-500">*</span></label>
                        <select
                            name="related_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            x-model="relatedId"
                            :required="type === 'variant'">
                            <option value="" x-text="variants.length === 0 ? 'Loading variants...' : 'Select Variant'"></option>
                            <template x-for="variant in variants" :key="variant.id">
                                <option :value="variant.id" x-text="`${variant.sku || 'Variant #' + variant.id} - $${variant.price}`"></option>
                            </template>
                        </select>
                    </div>
                </template>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="<?= url('admin/gallery') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition">
                    Upload Image
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('galleryForm', (categories, products) => ({
                imageUrl: 'https://placehold.co/400x300/e5e7eb/6b7280?text=Click+to+Select+Image',
                imageFile: null,
                title: '',
                type: '',
                relatedId: '',
                selectedProduct: '',
                variants: [],
                categories: categories,
                products: products,

                onFileChange(e) {
                    const file = e.target.files[0];
                    this.imageFile = file;
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            this.imageUrl = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.imageUrl = 'https://placehold.co/400x300/e5e7eb/6b7280?text=Click+to+Select+Image';
                    }
                },

                async loadVariants() {
                    if (!this.selectedProduct) {
                        this.variants = [];
                        this.relatedId = '';
                        return;
                    }

                    try {
                        const response = await fetch(`<?= url('admin/products/') ?>/${this.selectedProduct}/variants-json`);
                        const data = await response.json();
                        this.variants = data.variants || [];
                        this.relatedId = '';
                    } catch (error) {
                        console.error('Error loading variants:', error);
                        this.variants = [];
                    }
                },

                init() {
                    this.$watch('type', value => {
                        if (value === 'site') {
                            this.relatedId = '';
                            this.selectedProduct = '';
                            this.variants = [];
                        } else if (value !== 'variant') {
                            this.selectedProduct = '';
                            this.variants = [];
                        }
                    });
                }
            }));
        });
    </script>
</div>