<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-blue-900">Gallery</h1>
    <a href="<?= url('admin/gallery/create') ?>" class="bg-blue-600 text-white hover:bg-blue-700 border border-blue-700 rounded px-4 py-2 font-semibold transition shadow-sm text-sm">Add Image</a>
</div>
<!-- Site Images Section -->
<?php foreach ($gallery as $category => $images): ?>
    <h2 class="text-lg font-bold text-blue-700 mb-2 mt-8 capitalize"><?= htmlspecialchars($category) ?> Images</h2>
    <?php if (empty($images)): ?>
        <div class="p-4 text-center text-blue-400 bg-white rounded-lg shadow border border-blue-100">No images found.</div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
            <?php foreach ($images as $image): ?>
                <div class="bg-white rounded-lg shadow border border-blue-100 overflow-hidden flex flex-col">
                    <img src="/<?= e($image['image_url']) ?>" alt="<?= e($image['title']) ?>" class="w-full h-28 object-cover">
                    <div class="p-2 flex-1 flex flex-col justify-between">
                        <div class="font-semibold text-blue-900 text-xs truncate mb-1" title="<?= e($image['title']) ?>"><?= e($image['title']) ?></div>
                        <?php if (!empty($image['caption'])): ?>
                            <div class="text-[10px] text-gray-600 truncate mb-1" title="<?= e($image['caption']) ?>"><?= e($image['caption']) ?></div>
                        <?php endif; ?>
                        <div class="flex gap-1 mt-auto">
                            <a href="<?= url('admin/gallery/' . $image['id']) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-2 py-0.5 font-semibold transition shadow-sm text-[10px]">View</a>
                            <form method="POST" action="<?= url('admin/gallery/' . $image['id']) ?>" class="inline" onsubmit="return confirm('Delete this image?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-0.5 font-semibold transition shadow-sm text-[10px]">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>