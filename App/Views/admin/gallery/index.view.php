<!-- Header Section -->
<div class="bg-linear-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 mb-8 border border-blue-800">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                Gallery Manager
            </h1>
            <p class="text-blue-100 text-sm">Manage all your site images and media</p>
        </div>
        <a href="<?= url('admin/gallery/create') ?>" class="bg-white text-blue-600 hover:bg-blue-50 rounded-lg px-5 py-2.5 font-semibold transition shadow-md hover:shadow-lg flex items-center gap-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New Image
        </a>
    </div>
</div>

<!-- Gallery Categories -->
<?php foreach ($gallery as $category => $images): ?>
    <!-- Category Header -->
    <div class="flex items-center gap-3 mb-4 mt-8">
        <div class="bg-blue-100 text-blue-700 rounded-lg p-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-800 capitalize"><?= htmlspecialchars($category) ?> Images</h2>
        <div class="flex-1 border-t-2 border-blue-200 ml-3"></div>
    </div>

    <?php if (empty($images)): ?>
        <div class="bg-blue-50 border-2 border-dashed border-blue-200 rounded-xl p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-blue-300 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <p class="text-blue-400 font-medium">No images found in this category</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-8">
            <?php foreach ($images as $image): ?>
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:-translate-y-1 flex flex-col">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden bg-gray-100">
                        <img src="/<?= e($image['image_url']) ?>" alt="<?= e($image['title']) ?>" class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-linear-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Content -->
                    <div class="p-3 flex-1 flex flex-col">
                        <div class="font-semibold text-gray-800 text-sm truncate mb-1" title="<?= e($image['title']) ?>"><?= e($image['title']) ?></div>
                        <?php if (!empty($image['caption'])): ?>
                            <div class="text-xs text-gray-500 line-clamp-2 mb-2 flex-1" title="<?= e($image['caption']) ?>"><?= e($image['caption']) ?></div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="flex gap-1.5 mt-auto pt-2 border-t border-gray-100">
                            <a href="<?= url('admin/gallery/' . $image['id']) ?>" class="flex-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg px-3 py-1.5 font-medium transition text-xs text-center flex items-center justify-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                View
                            </a>
                            <form method="POST" action="<?= url('admin/gallery/' . $image['id'] . '/delete') ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 rounded-lg px-3 py-1.5 font-medium transition text-xs flex items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>