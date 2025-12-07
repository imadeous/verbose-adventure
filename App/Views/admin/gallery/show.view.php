<?php
// ...existing code...
?>
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
    <img src="/<?= e($item->image_url) ?>" alt="<?= e($item->title) ?>" class="w-full h-64 object-cover rounded mb-4">
    <div class="font-bold text-xl text-blue-900 mb-2"><?= e($item->title) ?></div>
    <?php if (!empty($item->caption)): ?>
        <div class="text-gray-700 mb-2"><?= e($item->caption) ?></div>
    <?php endif; ?>
    <div class="text-sm text-gray-500 mb-4">
        <div><strong>Type:</strong> <span class="capitalize"><?= e($item->image_type) ?></span></div>
        <?php if ($item->related_id): ?>
            <div><strong>Related ID:</strong> <?= e($item->related_id) ?></div>
        <?php endif; ?>
    </div>
    <div class="flex gap-2 mt-4">
        <a href="<?= url('admin/gallery/' . $item->id . '/edit') ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">Edit</a>
        <form action="<?= url('admin/gallery/' . $item->id) ?>" method="POST" class="inline" onsubmit="return confirm('Delete this image?')">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm text-xs">Delete</button>
        </form>
        <a href="<?= url('admin/gallery') ?>" class="ml-auto text-blue-500 hover:underline">Back to Gallery</a>
    </div>
</div>