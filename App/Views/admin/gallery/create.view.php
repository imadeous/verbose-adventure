<div class="max-w-xl mx-auto overflow-x-hidden">
    <div
        x-data='galleryForm(<?= json_encode($categories) ?>, <?= json_encode($products) ?>)'
        class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Add Gallery Image</h1>
        <form class="space-y-5" autocomplete="off" method="POST" action="<?= url('admin/gallery') ?>">
            <div class="flex flex-col md:flex-row gap-6">
                <?php csrf_field(); ?>
                <!-- Left Column: Label, Input, Preview -->
                <div class="flex-1">
                    <label class="block text-blue-700 font-semibold mb-1">Image</label>
                    <label class="block cursor-pointer group w-fit">
                        <img
                            :src="imageUrl"
                            alt="Select Image"
                            class="rounded border border-blue-200 shadow w-64 h-48 object-cover transition ring-2 ring-transparent group-hover:ring-blue-400"
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
                </div>
                <!-- Right Column: Image Data -->
                <div class="flex-1 flex flex-col justify-center">
                    <template x-if="imageFile">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 text-blue-900 text-sm space-y-2">
                            <div><span class="font-semibold">Name:</span> <span x-text="imageFile.name"></span></div>
                            <div>
                                <span class="font-semibold">Size:</span>
                                <span :class="imageFile.size > 2 * 1024 * 1024 ? 'text-red-600' : ''" x-text="(imageFile.size/1024).toFixed(2) + ' KB'"></span>
                            </div>
                            <div><span class="font-semibold">Type:</span> <span x-text="imageFile.type"></span></div>
                            <div><span class="font-semibold">Extension:</span> <span x-text="imageFile.name.split('.').pop()"></span></div>
                        </div>
                    </template>
                    <template x-if="!imageFile">
                        <div class="text-blue-400 italic">No image selected</div>
                    </template>
                </div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Title</label>
                <input
                    type="text"
                    name="title"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900"
                    x-model="title"
                    required>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Caption</label>
                <input
                    type="text"
                    name="caption"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900">
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Type</label>
                <select
                    name="image_type"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900"
                    x-model="type"
                    required>
                    <option value="">Select Type</option>
                    <option value="site">Site</option>
                    <option value="category">Category</option>
                    <option value="product">Product</option>
                </select>
            </div>
            <div x-show="type && type !== 'site'" x-transition>
                <label class="block text-blue-700 font-semibold mb-1">Related ID</label>
                <select
                    name="related_id"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900"
                    x-model="relatedId"
                    :required="type !== 'site'">
                    <?php if (!empty($categories) && !empty($products)): ?>
                        <optgroup label="Categories" x-show="type === 'category'">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= e($category->id) ?>" x-show="type === 'category'"><?= e($category->name) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Products" x-show="type === 'product'">
                            <?php foreach ($products as $product): ?>
                                <option value="<?= e($product->id) ?>" x-show="type === 'product'"><?= e($product->name) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                </select>
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-400">Upload</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('galleryForm', () => ({
                imageUrl: 'https://placehold.co/100x80/3b82f6/fff?text=Preview',
                imageFile: null,
                title: '',
                type: '',
                relatedId: '',
                categories: <?= json_encode($categories) ?>,
                products: <?= json_encode($products) ?>,
                isValid() {
                    if (!this.imageFile || !this.title.trim() || !this.type) return false;
                    if (this.type !== 'site' && !this.relatedId) return false;
                    return true;
                },
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
                        this.imageUrl = 'https://placehold.co/100x80/3b82f6/fff?text=Select+Image';
                    }
                },
                // Watch for type changes and clear relatedId if type is 'site'
                init() {
                    this.$watch('type', value => {
                        if (value === 'site') this.relatedId = '';
                    });
                }
            }));
        });
    </script>
    </form>
</div>
</div>