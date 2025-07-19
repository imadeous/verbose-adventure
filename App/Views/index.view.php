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

    <!-- Stats Section -->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 mx-auto">
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
                        <h2
                            x-data="{ count: 0 }"
                            x-init="let target = 2700; let step = Math.ceil(target / 60); let interval = setInterval(() => { if(count < target) { count += step; if(count > target) count = target; } else { clearInterval(interval); } }, 20);"
                            x-text="count.toLocaleString() + '+'"
                            class="title-font font-medium text-3xl text-white">
                        </h2>
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
                        <h2
                            x-data="{ count: 0 }"
                            x-init="let target = 1300; let step = Math.ceil(target / 60); let interval = setInterval(() => { if(count < target) { count += step; if(count > target) count = target; } else { clearInterval(interval); } }, 20);"
                            x-text="count.toLocaleString() + '+'"
                            class="title-font font-medium text-3xl text-white">
                        </h2>
                        <p class="leading-relaxed">Happy Clients</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M3 18v-6a9 9 0 0118 0v6"></path>
                            <path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"></path>
                        </svg>
                        <h2
                            x-data="{ count: 0 }"
                            x-init="let target = 74; let step = 1; let interval = setInterval(() => { if(count < target) { count += step; if(count > target) count = target; } else { clearInterval(interval); } }, 20);"
                            x-text="count"
                            class="title-font font-medium text-3xl text-white">
                        </h2>
                        <p class="leading-relaxed">Designs Available</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-800 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-yellow-400 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <h2
                            x-data="{ count: 0 }"
                            x-init="let target = 46; let step = 1; let interval = setInterval(() => { if(count < target) { count += step; if(count > target) count = target; } else { clearInterval(interval); } }, 20);"
                            x-text="count"
                            class="title-font font-medium text-3xl text-white">
                        </h2>
                        <p class="leading-relaxed">Cities Served</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Stats Section -->

    <!--featured section-->
    <section class="text-gray-400 bg-gray-900 py-12 body-font">
        <div class="container px-5 py-24 mx-auto flex flex-wrap">
            <div class="flex flex-col w-full mb-20 flex-wrap">
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-white lg:w-1/3 lg:mb-0 mb-4">Featured Prints & Projects</h1>
                <div class="h-1 w-20 bg-yellow-500 rounded"></div>
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
            }" class="relative w-full max-w-8xl h-96 mx-auto">
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
                <div class="flex justify-center mt-8 space-x-2">
                    <template x-for="(img, i) in images" :key="'dot-' + i">
                        <button @click="current = i" :class="{'bg-yellow-500': current === i, 'bg-gray-600': current !== i}" class="w-3 h-3 rounded-full focus:outline-none"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- machines section -->
    <section class="text-gray-400 body-font bg-gray-900">
        <div class="container px-5 py-4 mx-auto">
            <div class="flex flex-wrap w-full mb-20">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-white">Our 3D Printing Machines</h1>
                    <div class="h-1 w-20 bg-yellow-500 rounded"></div>
                </div>
                <p class="lg:w-1/2 w-full leading-relaxed text-gray-400 text-opacity-90">
                    We use a range of professional 3D printers to deliver exceptional quality and precision for every project. From rapid prototyping to high-detail production, our machines are selected for their reliability, accuracy, and versatility. Explore some of the key printers that power our workshop below.
                </p>
            </div>
            <div class="flex flex-wrap -m-4">
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">FDM PRINTER</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Prusa i3 MK3S+</h2>
                        <p class="leading-relaxed text-base">A workhorse for reliable, high-quality prints in PLA, PETG, and more. Perfect for prototypes, functional parts, and large models with excellent repeatability.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/721x401" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">RESIN PRINTER</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Anycubic Photon Mono X</h2>
                        <p class="leading-relaxed text-base">Delivers ultra-fine detail and smooth surfaces for miniatures, jewelry, and intricate models. Ideal for projects requiring high resolution and sharp features.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/722x402" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">LARGE FORMAT</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Creality CR-10 Max</h2>
                        <p class="leading-relaxed text-base">Handles oversized prints and batch production with ease. Its large build volume is perfect for architectural models, cosplay props, and multi-part assemblies.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/723x403" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">DUAL EXTRUDER</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">FlashForge Creator Pro 2</h2>
                        <p class="leading-relaxed text-base">Enables multi-material and multi-color printing for advanced projects. Great for engineering parts, complex assemblies, and creative designs with soluble supports.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End machines section -->
    <!--how to order section-->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto flex flex-wrap">
            <div class="flex relative pt-10 pb-20 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-white relative z-10 title-font font-medium text-sm">1</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-400 rounded-full inline-flex items-center justify-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <h2 class="font-medium title-font text-white mb-1 text-xl">1. Submit Your 3D Model or Idea</h2>
                        <p class="leading-relaxed">Upload your 3D file or describe your project using our online form. Our team will review your submission and reach out if we need more details.</p>
                    </div>
                </div>
            </div>
            <div class="flex relative pb-20 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-white relative z-10 title-font font-medium text-sm">2</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-400 rounded-full inline-flex items-center justify-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <h2 class="font-medium title-font text-white mb-1 text-xl">2. Receive a Quote & Approve</h2>
                        <p class="leading-relaxed">We’ll send you a detailed quote based on your design, material, and finish preferences. Review and approve the quote to start production.</p>
                    </div>
                </div>
            </div>
            <div class="flex relative pb-20 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-white relative z-10 title-font font-medium text-sm">3</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-400 rounded-full inline-flex items-center justify-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="3"></circle>
                            <path d="M12 22V8M5 12H2a10 10 0 0020 0h-3"></path>
                        </svg>
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <h2 class="font-medium title-font text-white mb-1 text-xl">3. Printing & Quality Check</h2>
                        <p class="leading-relaxed">Your part is printed using our professional machines. Every order is inspected for quality and accuracy before shipping or pickup.</p>
                    </div>
                </div>
            </div>
            <div class="flex relative pb-10 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-white relative z-10 title-font font-medium text-sm">4</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-400 rounded-full inline-flex items-center justify-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-12 h-12" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <h2 class="font-medium title-font text-white mb-1 text-xl">4. Delivery or Pickup</h2>
                        <p class="leading-relaxed">We ship your finished part securely to your address, or you can choose to pick it up at our workshop. Enjoy your custom 3D print!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--testimonials section-->
    <section class="text-gray-400 bg-gray-900 body-font">
        <div class="container px-5 py-24 mx-auto">
            <h1 class="text-3xl font-medium title-font text-white mb-12 text-center">Testimonials</h1>
            <div class="flex flex-wrap -m-4">
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-gray-800 bg-opacity-40 p-8 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-500 mb-4" viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                        </svg>
                        <p class="leading-relaxed mb-6">Craftophile brought my prototype to life with incredible precision and speed. The team was responsive, and the final product exceeded my expectations. I highly recommend their 3D printing services to anyone looking for quality and professionalism.</p>
                        <a class="inline-flex items-center">
                            <img alt="testimonial" src="https://dummyimage.com/106x106" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-white">Priya Sharma</span>
                                <span class="text-gray-500 text-sm">Product Designer</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-gray-800 bg-opacity-40 p-8 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-500 mb-4" viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                        </svg>
                        <p class="leading-relaxed mb-6">I needed a batch of custom parts for my robotics project, and Craftophile delivered flawless prints ahead of schedule. The quality and attention to detail were outstanding. I’ll definitely use their services again for future projects.</p>
                        <a class="inline-flex items-center">
                            <img alt="testimonial" src="https://dummyimage.com/107x107" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-white">Michael Lee</span>
                                <span class="text-gray-500 text-sm">Engineering Student</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>