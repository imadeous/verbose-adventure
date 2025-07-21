<h1 class="text-2xl font-bold text-blue-900 mb-6">Add Image (Static UI Demo)</h1>
<form class="space-y-6 max-w-lg">
    <div>
        <label class="block font-semibold mb-1">Image</label>
        <div class="flex items-center gap-4">
            <input type="file" name="image" class="block w-full border rounded px-3 py-2" disabled>
            <img src="https://placehold.co/100x80/3b82f6/fff?text=Preview" alt="Preview" class="rounded border border-blue-200 shadow w-24 h-20 object-cover">
        </div>
    </div>
    <div>
        <label class="block font-semibold mb-1">Caption</label>
        <input type="text" name="caption" class="block w-full border rounded px-3 py-2" value="Sample Caption" disabled>
    </div>
    <button type="button" class="bg-blue-400 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-400 opacity-60 cursor-not-allowed" disabled>Upload</button>
</form>