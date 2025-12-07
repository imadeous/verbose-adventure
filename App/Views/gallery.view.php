<!-- stats section -->
<section class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap">
        <div class="flex flex-wrap -mx-4 mt-auto mb-auto lg:w-1/2 sm:w-2/3 content-start sm:pr-10">
            <div class="w-full sm:p-4 px-4 mb-6">
                <h1 class="title-font font-medium text-xl mb-2 text-white">Gallery Highlights</h1>
                <div class="leading-relaxed">Discover some of our favorite 3D printed projects, from intricate prototypes to finished products. Each piece demonstrates our commitment to quality, detail, and customer satisfaction.</div>
            </div>
            <div
                x-data="{
                    stats: [
                        { label: 'Products', value: <?= $totalProducts ?? 0 ?>, display: 0 },
                        { label: 'Gallery Items', value: <?= $totalGalleryItems ?? 0 ?>, display: 0 },
                        { label: 'Categories', value: <?= count(array_unique(array_column($galleryItems ?? [], 'category_name'))) ?>, display: 0 },
                        { label: 'Images', value: <?= array_sum(array_column($galleryItems ?? [], 'image_count')) ?>, display: 0 }
                    ],
                    animate(idx) {
                        let stat = this.stats[idx];
                        let start = 0;
                        let end = stat.value;
                        let duration = 1200;
                        let stepTime = Math.abs(Math.floor(duration / end));
                        let startTime = null;
                        const step = (timestamp) => {
                            if (!startTime) startTime = timestamp;
                            let progress = timestamp - startTime;
                            let current = Math.min(Math.round((progress / duration) * end), end);
                            this.stats[idx].display = current;
                            if (progress < duration) {
                                requestAnimationFrame(step);
                            } else {
                                this.stats[idx].display = end;
                            }
                        };
                        requestAnimationFrame(step);
                    }
                }"
                x-init="stats.forEach((_, idx) => animate(idx))"
                class="flex flex-wrap w-full">
                <template x-for="(stat, idx) in stats" :key="stat.label">
                    <div class="p-4 sm:w-1/2 lg:w-1/4 w-1/2">
                        <h2 class="title-font font-medium text-3xl text-yellow-500">
                            <span x-text="stat.format ? stat.format(stat.display) : stat.display"></span>
                        </h2>
                        <p class="leading-relaxed" x-text="stat.label"></p>
                    </div>
                </template>
            </div>
        </div>
        <div class="lg:w-1/2 sm:w-1/3 w-full rounded-lg overflow-hidden mt-6 sm:mt-0">
            <img class="object-cover object-center w-full h-full" src="https://dummyimage.com/600x300" alt="3D print gallery highlight">
        </div>
    </div>
</section>

<section class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 pt-12 pb-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Featured 3D Prints</h1>
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