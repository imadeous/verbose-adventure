<?php
// ...existing code...
?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Gallery</h1>
    <a href="<?= url('admin/gallery/create') ?>" class="btn btn-primary">Add Image</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($gallery as $item): ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <img src="/<?= e($item->image) ?>" alt="" class="w-full h-48 object-cover">
            <div class="p-4">
                <div class="font-semibold text-blue-900 mb-2"><?= e($item->caption) ?></div>
                <div class="flex gap-2">
                    <a href="<?= url('admin/gallery/' . $item->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">View</a>
                    <a href="<?= url('admin/gallery/' . $item->id . '/edit') ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">Edit</a>
                    <form action="<?= url('admin/gallery/' . $item->id . '/delete') ?>" method="POST" class="inline">
                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs" onclick="return confirm('Delete this image?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>