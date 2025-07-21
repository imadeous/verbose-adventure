<div class="max-w-xl mx-auto p-8">
    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Add Gallery Image</h1>
        <form class="space-y-5" autocomplete="off">
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Image</label>
                <input type="file" name="image" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" disabled>
                <div class="mt-2">
                    <img src="https://placehold.co/100x80/3b82f6/fff?text=Preview" alt="Preview" class="rounded border border-blue-200 shadow w-24 h-20 object-cover">
                </div>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Caption</label>
                <input type="text" name="caption" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" value="Sample Caption" disabled>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Type</label>
                <select name="image_type" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" disabled>
                    <option value="site">Site</option>
                    <option value="category">Category</option>
                    <option value="product">Product</option>
                </select>
            </div>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Related ID</label>
                <input type="number" name="related_id" class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-blue-900" value="" disabled>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-blue-400 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-400 opacity-60 cursor-not-allowed" disabled>Upload</button>
            </div>
        </form>
    </div>
</div>