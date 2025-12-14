<section class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 pt-12 pb-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Our 3D Print Projects Gallery</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Explore a curated selection of our recent 3D printed projects. From engineering prototypes to custom art pieces, each item highlights our precision, creativity, and commitment to quality.</p>
        </div>
        <div class="flex flex-wrap -m-4">
            <?php if (!empty($galleryItems)): ?>
                <?php foreach ($galleryItems as $item): ?>
                    <div class="lg:w-1/3 sm:w-1/2 p-4">
                        <a href="<?= url('/product/' . $item['id']) ?>" class="flex relative group cursor-pointer">
                            <img alt="<?= htmlspecialchars($item['name']) ?>"
                                class="absolute inset-0 w-full h-full object-cover object-center"
                                src="<?= htmlspecialchars($item['image_url']) ?>">
                            <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">
                                    <?= strtoupper(htmlspecialchars($item['category_name'])) ?>
                                </h2>
                                <h1 class="title-font text-lg font-medium text-white mb-3">
                                    <?= htmlspecialchars($item['name']) ?>
                                </h1>
                                <p class="leading-relaxed">
                                    <?= htmlspecialchars(substr($item['description'], 0, 150)) ?><?= strlen($item['description']) > 150 ? '...' : '' ?>
                                </p>
                                <?php if ($item['image_count'] > 1): ?>
                                    <p class="text-yellow-400 text-xs mt-2">
                                        +<?= $item['image_count'] - 1 ?> more image<?= $item['image_count'] > 2 ? 's' : '' ?>
                                    </p>
                                <?php endif; ?>
                                <div class="mt-4 flex items-center text-yellow-400 text-sm">
                                    <span>View Details</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-full text-center py-12">
                    <p class="text-gray-400 text-lg">No gallery items available yet. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- endsection gallery -->