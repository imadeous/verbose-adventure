<div class="max-w-6xl mx-auto p-8" x-data="productCreator()">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Add New Product</h1>
        <p class="text-gray-600 mt-2">Fill in the product details and upload up to 8 images</p>
    </div>

    <form action="<?= url('admin/products') ?>" method="POST" enctype="multipart/form-data" @submit="handleSubmit($event)">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Product Details -->
            <div class="lg:col-span-2 space-y-6">
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

            <!-- Right Column: Image Upload -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-blue-900 mb-4">Product Images</h2>
                    <p class="text-sm text-gray-600 mb-4">Upload up to 8 images (JPG, PNG, WebP)</p>

                    <!-- Drag & Drop Area -->
                    <div @drop.prevent="handleDrop($event)"
                        @dragover.prevent="dragOver = true"
                        @dragleave.prevent="dragOver = false"
                        :class="{ 'border-blue-500 bg-blue-50': dragOver, 'border-blue-300': !dragOver }"
                        class="border-2 border-dashed rounded-lg p-8 text-center transition-all cursor-pointer hover:border-blue-500 hover:bg-blue-50"
                        @click="$refs.fileInput.click()">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-blue-500 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>

                        <p class="text-gray-700 font-medium mb-2">Drag & Drop Images</p>
                        <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                        <p class="text-xs text-gray-400">Max 8 images • 5MB per file</p>

                        <input type="file"
                            ref="fileInput"
                            @change="handleFileSelect($event)"
                            multiple
                            accept="image/jpeg,image/png,image/webp,image/jpg"
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
                    <div class="mt-6 space-y-3 max-h-96 overflow-y-auto" x-show="selectedFiles.length > 0">
                        <template x-for="(file, index) in selectedFiles" :key="index">
                            <div class="flex items-center space-x-3 bg-blue-50 rounded-lg p-3 border border-blue-200">
                                <img :src="file.preview"
                                    :alt="file.name"
                                    class="w-16 h-16 object-cover rounded-lg border border-blue-300">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate" x-text="file.name"></p>
                                    <p class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></p>
                                </div>
                                <button type="button"
                                    @click="removeFile(index)"
                                    class="text-red-600 hover:text-red-800 hover:bg-red-100 p-2 rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Hidden file inputs for form submission -->
                    <div class="hidden">
                        <template x-for="(file, index) in selectedFiles" :key="index">
                            <input type="file"
                                :name="'images[' + index + ']'"
                                :id="'image_' + index"
                                class="image-file-input">
                        </template>
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
            <div class="flex items-center space-x-4">
                <span x-show="selectedFiles.length > 0" class="text-sm text-gray-600">
                    <span x-text="selectedFiles.length"></span> image<span x-show="selectedFiles.length !== 1">s</span> ready to upload
                </span>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                    Create Product
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function productCreator() {
        return {
            selectedFiles: [],
            dragOver: false,
            maxFiles: 8,
            maxFileSize: 5 * 1024 * 1024, // 5MB

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
                    if (!file.type.match('image/(jpeg|jpg|png|webp)')) {
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
                    alert(`Only ${remainingSlots} more image(s) can be added. Maximum is 8 images per product.`);
                }
            },

            removeFile(index) {
                this.selectedFiles.splice(index, 1);
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            },

            handleSubmit(event) {
                // Create a FormData object to handle file uploads
                const form = event.target;
                const formData = new FormData(form);

                // Remove old file inputs
                formData.delete('images');

                // Add actual files to FormData
                this.selectedFiles.forEach((fileObj, index) => {
                    formData.append(`images[${index}]`, fileObj.file);
                });

                // If we have files, we need to submit via AJAX or modify form submission
                if (this.selectedFiles.length > 0) {
                    // Let the form submit naturally with files
                    // The hidden inputs are replaced by actual file data
                    const hiddenInputs = form.querySelectorAll('.image-file-input');
                    hiddenInputs.forEach(input => input.remove());

                    this.selectedFiles.forEach((fileObj, index) => {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(fileObj.file);

                        const input = document.createElement('input');
                        input.type = 'file';
                        input.name = `images[${index}]`;
                        input.files = dataTransfer.files;
                        input.style.display = 'none';
                        form.appendChild(input);
                    });
                }
            }
        }
    }
</script>