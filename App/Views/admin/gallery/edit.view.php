<?php
// ...existing code...
?>
<h1 class="text-2xl font-bold mb-6">Edit Image</h1>
<form action="<?= url('admin/gallery/' . $item->id . '/edit') ?>" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-lg">
    <div>
        <label class="block font-semibold mb-1">Current Image</label>
        <img src="/<?= e($item->image) ?>" alt="" class="w-48 h-32 object-cover rounded mb-2">
        <input type="file" name="image" class="block w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block font-semibold mb-1">Caption</label>
        <input type="text" name="caption" value="<?= e($item->caption) ?>" class="block w-full border rounded px-3 py-2">
    </div>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Save Changes</button>
</form>