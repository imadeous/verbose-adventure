<div class="relative isolate">
    <!-- Hero Section -->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-white">Bring Your Ideas to Life
                    <br class="hidden lg:inline-block">with Professional 3D Printing
                </h1>
                <p class="mb-8 leading-relaxed">Craftophile Shop offers high-quality, affordable 3D printing services for hobbyists, creators, and businesses. Upload your design or choose from our gallery, and let us turn your vision into reality with precision and care.</p>
                <div class="flex justify-center">
                    <a href="<?= url('/quote') ?>" class="inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg">Get a Quote</a>
                    <a href="<?= url('/gallery') ?>" class="ml-4 inline-flex text-gray-400 bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-700 hover:text-white rounded text-lg">View Gallery</a>
                </div>
            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                <img class="object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600">
            </div>
        </div>
    </section>
    <!-- End Hero Section -->

    <!--featured section-->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto flex flex-wrap">
            <div class="flex w-full mb-20 flex-wrap">
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-white lg:w-1/3 lg:mb-0 mb-4">Featured Prints & Projects</h1>
                <p class="lg:pl-6 lg:w-2/3 mx-auto leading-relaxed text-base">Explore our latest 3D printed creations, from custom prototypes to artistic models. Each project showcases the versatility and quality of our printing technology. Get inspired for your next idea!</p>
            </div>
            <div x-data="{
                images: [
                    {src: 'https://dummyimage.com/500x300'},
                    {src: 'https://dummyimage.com/501x301'},
                    {src: 'https://dummyimage.com/600x360'},
                    {src: 'https://dummyimage.com/601x361'},
                    {src: 'https://dummyimage.com/502x302'},
                    {src: 'https://dummyimage.com/503x303'},
                ],
                current: 0,
                prev() { this.current = (this.current === 0) ? this.images.length - 1 : this.current - 1; },
                next() { this.current = (this.current === this.images.length - 1) ? 0 : this.current + 1; }
            }" class="relative w-full max-w-4xl mx-auto">
                <div class="overflow-hidden rounded-lg">
                    <div class="relative w-full h-64 md:h-80 overflow-hidden">
                        <template x-for="(img, i) in images" :key="i">
                            <img :src="img.src" alt="gallery"
                                class="w-3/4 md:w-2/3 h-64 md:h-80 object-cover object-center absolute top-0 transition-transform transition-opacity duration-500"
                                :class="{
                                    // Current image
                                    'left-1/2 -translate-x-1/2 z-20 opacity-100 scale-100': current === i,
                                    // Previous image (left, offset)
                                    'left-0 translate-x-[-30%] z-10 opacity-40 scale-90': (current === 0 ? images.length - 1 : current - 1) === i,
                                    // Next image (right, offset)
                                    'right-0 translate-x-[30%] z-10 opacity-40 scale-90': (current === images.length - 1 ? 0 : current + 1) === i,
                                    // All others
                                    'opacity-0 scale-90 z-0': (current !== i) && ((current === 0 ? images.length - 1 : current - 1) !== i) && ((current === images.length - 1 ? 0 : current + 1) !== i)
                                }"
                                style="will-change: transform, opacity; pointer-events: none;">
                        </template>
                    </div>
                </div>
                <!-- Navigation Arrows -->
                <button @click="prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-800 bg-opacity-60 hover:bg-opacity-90 text-white rounded-full p-2 focus:outline-none z-30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-800 bg-opacity-60 hover:bg-opacity-90 text-white rounded-full p-2 focus:outline-none z-30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <!-- Indicators -->
                <div class="flex justify-center mt-4 space-x-2">
                    <template x-for="(img, i) in images" :key="'dot-' + i">
                        <button @click="current = i" :class="{'bg-yellow-500': current === i, 'bg-gray-600': current !== i}" class="w-3 h-3 rounded-full focus:outline-none"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>


    <!-- Stats Section -->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Why Choose Craftophile?</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">We combine advanced 3D printing technology with expert craftsmanship to deliver outstanding results. Whether you need a single prototype or a batch of custom parts, our team is here to help you every step of the way.</p>
            </div>
            <div class="flex flex-wrap -m-4 text-center">
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M8 17l4 4 4-4m-4-5v9"></path>
                            <path d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-white">2.7K+</h2>
                        <p class="leading-relaxed">Prints Completed</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-white">1.3K+</h2>
                        <p class="leading-relaxed">Happy Clients</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M3 18v-6a9 9 0 0118 0v6"></path>
                            <path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-white">74</h2>
                        <p class="leading-relaxed">Designs Available</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-white">46</h2>
                        <p class="leading-relaxed">Cities Served</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Stats Section -->

</div>