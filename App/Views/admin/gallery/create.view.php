<div class="max-w-4xl mx-auto overflow-x-hidden" x-data='galleryForm(<?= json_encode($categories) ?>, <?= json_encode($products) ?>)'>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Add Gallery Images</h1>
        <p class="text-gray-600 mb-6">Upload up to 8 images at once</p>

        <form class="space-y-6" autocomplete="off" method="POST" action="<?= url('admin/gallery') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Image Upload Section -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Upload Images (Max 8)</label>

                <!-- Drag & Drop Area -->
                <div @drop.prevent="handleDrop($event)"
                    @dragover.prevent="dragOver = true"
                    @dragleave.prevent="dragOver = false"
                    :class="{ 'border-blue-500 bg-blue-50': dragOver, 'border-gray-300': !dragOver }"
                    class="border-2 border-dashed rounded-lg p-8 text-center transition-all cursor-pointer hover:border-blue-500 hover:bg-blue-50"
                    @click="$refs.fileInput.click()">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-blue-500 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>

                    <p class="text-gray-700 font-medium mb-2">Drag & Drop Images</p>
                    <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                    <p class="text-xs text-gray-400">Max 8 images • 5MB per file • JPG, PNG, GIF, WebP</p>

                    <input type="file"
                        ref="fileInput"
                        @change="handleFileSelect($event)"
                        multiple
                        accept="image/*"
                        class="hidden">
                </div>

                <!-- Image Counter -->
                <div class="mt-4 flex items-center justify-between text-sm">
                    <span class="text-gray-600">Images selected:</span>
                    <span class="font-semibold" :class="selectedFiles.length >= 8 ? 'text-red-600' : 'text-blue-600'">
                        <span x-text="selectedFiles.length"></span> / 8
                    </span>
                </div>

                <!-- Image Previews -->
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4" x-show="selectedFiles.length > 0">
                    <template x-for="(file, index) in selectedFiles" :key="index">
                        <div class="relative group">
                            <img :src="file.preview"
                                :alt="file.name"
                                class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                            <button type="button"
                                @click="removeFile(index)"
                                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition hover:bg-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <p class="text-xs text-gray-600 mt-1 truncate" x-text="file.name"></p>
                        </div>
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
                    :disabled="selectedFiles.length === 0"
                    :class="selectedFiles.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition">
                    Upload <span x-text="selectedFiles.length"></span> Image<span x-show="selectedFiles.length !== 1">s</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('galleryForm', (categories, products) => ({
            selectedFiles: [],
            dragOver: false,
            maxFiles: 8,
            maxFileSize: 5 * 1024 * 1024, // 5MB
            title: '',
            type: '',
            relatedId: '',
            selectedProduct: '',
            variants: [],
            categories: categories,
            products: products,

            handleFileSelect(event) {
                this.addFiles(event.target.files);
            },

            handleDrop(event) {
                this.dragOver = false;
                this.addFiles(event.dataTransfer.files);
            },

            addFiles(files) {
                const fileArray = Array.from(files);
                const remainingSlots = this.maxFiles - this.selectedFiles.length;

                if (remainingSlots <= 0) {
                    alert('Maximum 8 images allowed. Please remove some images first.');
                    return;
                }

                const filesToAdd = fileArray.slice(0, remainingSlots);

                filesToAdd.forEach(file => {
                    // Validate file type
                    if (!file.type.match('image/(jpeg|jpg|png|gif|webp)')) {
                        alert(`${file.name} is not a supported image format.`);
                        return;
                    }

                    // Validate file size
                    if (file.size > this.maxFileSize) {
                        alert(`${file.name} is too large. Maximum size is 5MB.`);
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.selectedFiles.push({
                            file: file,
                            name: file.name,
                            size: file.size,
                            preview: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                });

                if (fileArray.length > remainingSlots) {
                    alert(`Only ${remainingSlots} more image(s) can be added. Maximum is 8 images.`);
                }
            },

            removeFile(index) {
                this.selectedFiles.splice(index, 1);
            },

            async loadVariants() {
                if (!this.selectedProduct) {
                    this.variants = [];
                    this.relatedId = '';
                    return;
                }

                try {
                    const response = await fetch(`<?= url('admin/products') ?>/${this.selectedProduct}/variants-json`);
                    const data = await response.json();
                    this.variants = data.variants || [];
                    this.relatedId = '';
                } catch (error) {
                    console.error('Error loading variants:', error);
                    this.variants = [];
                }
            },

            init() {
                // Create hidden file inputs dynamically when form is submitted
                this.$el.querySelector('form').addEventListener('submit', (e) => {
                    // Remove old hidden inputs
                    const oldInputs = this.$el.querySelectorAll('.dynamic-file-input');
                    oldInputs.forEach(input => input.remove());

                    // Add files to form
                    this.selectedFiles.forEach((fileObj, index) => {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(fileObj.file);

                        const input = document.createElement('input');
                        input.type = 'file';
                        input.name = `images[${index}]`;
                        input.files = dataTransfer.files;
                        input.className = 'dynamic-file-input';
                        input.style.display = 'none';
                        e.target.appendChild(input);
                    });
                });
            }
        }));
    });
</script>
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