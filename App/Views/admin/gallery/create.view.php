<div class="max-w-xl mx-auto overflow-x-hidden">
    <div
        x-data="galleryForm"
        class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Add Gallery Image</h1>
        <form class="space-y-5" autocomplete="off" @submit.prevent>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Image</label>
                <input
                    type="file"
                    name="image"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900"
                    required
                    accept="image/*"
                    @change="onFileChange">
                <div class="mt-2">
                    <img :src="imageUrl" alt="Preview" class="rounded border border-blue-200 shadow w-24 h-20 object-cover">
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
                <input
                    type="number"
                    name="related_id"
                    class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900"
                    x-model="relatedId"
                    :required="type !== 'site'">
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-400 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-400"
                    :class="isValid() ? 'opacity-100 cursor-pointer' : 'opacity-60 cursor-not-allowed'"
                    :disabled="!isValid()">Upload</button>
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
                        this.imageUrl = 'https://placehold.co/100x80/3b82f6/fff?text=Preview';
                    }
                }
            }));
        });
    </script>
    </form>
</div>
</div>