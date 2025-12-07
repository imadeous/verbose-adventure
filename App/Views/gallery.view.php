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
                        { label: 'Machines', value: 2, display: 0 },
                        { label: 'Materials', value: 5, display: 0 },
                        { label: 'Prints', value: 153, display: 0 },
                        { label: 'Followers', value: 2300, display: 0, format: v => v >= 1000 ? (v/1000).toFixed(1) + 'K' : v }
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
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/600x360">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">PROTOTYPE</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Custom Gear Assembly</h1>
                        <p class="leading-relaxed">Precision-engineered gears for a robotics client, demonstrating tight tolerances and smooth mechanical function.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/601x361">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">ART PIECE</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Modern Sculpture</h1>
                        <p class="leading-relaxed">A unique, multi-material sculpture designed for a local artist, showcasing complex geometry and vibrant color blending.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/603x363">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">PRODUCT DESIGN</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Ergonomic Handle</h1>
                        <p class="leading-relaxed">Functional prototype for a kitchenware startup, featuring an ergonomic grip and food-safe materials.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/602x362">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">ARCHITECTURAL MODEL</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Residential Scale Model</h1>
                        <p class="leading-relaxed">Detailed scale model of a modern home, used by architects to visualize and present their designs to clients.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/605x365">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">EDUCATIONAL TOOL</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Molecular Model Kit</h1>
                        <p class="leading-relaxed">A set of interlocking molecular models for a local school, designed to help students visualize complex chemical structures.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 sm:w-1/2 p-4">
                <div class="flex relative">
                    <img alt="gallery" class="absolute inset-0 w-full h-full object-cover object-center" src="https://dummyimage.com/606x366">
                    <div class="px-8 py-10 relative z-10 w-full border-4 border-gray-800 bg-gray-900 opacity-0 hover:opacity-100">
                        <h2 class="tracking-widest text-sm title-font font-medium text-yellow-400 mb-1">CUSTOM MINIATURE</h2>
                        <h1 class="title-font text-lg font-medium text-white mb-3">Fantasy Game Figure</h1>
                        <p class="leading-relaxed">Highly detailed miniature for tabletop gaming, painted and finished to client specifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- endsection gallery -->