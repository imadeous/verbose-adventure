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
                <img class="object-cover object-center rounded" alt="hero" src="<?= asset('storage/site/cover.png') ?>">
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
            <div class="flex flex-wrap w-full mb-20">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-white">Featured Prints & Projects</h1>
                    <div class="h-1 w-20 bg-yellow-500 rounded"></div>
                </div>
                <p class="lg:w-1/2 w-full leading-relaxed text-gray-400 text-opacity-90">
                    Explore our latest 3D printed creations, from custom prototypes to artistic models. Each project showcases the versatility and quality of our printing technology. Get inspired for your next idea!.
                </p>
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
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="<?= asset('storage/site/Prusa i3 MK3S+.png') ?>" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">FDM PRINTER</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Prusa i3 MK3S+</h2>
                        <p class="leading-relaxed text-base">A workhorse for reliable, high-quality prints in PLA, PETG, and more. Perfect for prototypes, functional parts, and large models with excellent repeatability.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="<?= asset('storage/site/Anycubic Photon Mono X.png') ?>" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">RESIN PRINTER</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Anycubic Photon Mono X</h2>
                        <p class="leading-relaxed text-base">Delivers ultra-fine detail and smooth surfaces for miniatures, jewelry, and intricate models. Ideal for projects requiring high resolution and sharp features.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="<?= asset('storage/site/Creality CR-10 Max.png') ?>" alt="content">
                        <h3 class="tracking-widest text-yellow-400 text-xs font-medium title-font">LARGE FORMAT</h3>
                        <h2 class="text-lg text-white font-medium title-font mb-4">Creality CR-10 Max</h2>
                        <p class="leading-relaxed text-base">Handles oversized prints and batch production with ease. Its large build volume is perfect for architectural models, cosplay props, and multi-part assemblies.</p>
                    </div>
                </div>
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="<?= asset('storage/site/FlashForge Creator Pro 2.png') ?>" alt="content">
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
            <div class="flex flex-wrap w-full mb-20">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-white">How to Order</h1>
                    <div class="h-1 w-20 bg-yellow-500 rounded"></div>
                </div>
                <p class="lg:w-1/2 w-full leading-relaxed text-gray-400 text-opacity-90">
                    Ordering your custom 3D print is simple and hassle-free. Just follow these four easy steps to bring your ideas to life, from submitting your design to receiving your finished part.
                </p>
            </div>
            <div class="flex relative pt-10 pb-20 sm:items-center md:w-2/3 mx-auto">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-gray-900 relative z-10 title-font font-semibold text-sm">1</div>
                <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-500 rounded-full inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                        </svg>
                    </div>
                    <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                        <h2 class="font-medium title-font text-white mb-1 text-xl">Submit Your 3D Model or Idea</h2>
                        <p class="leading-relaxed">Upload your 3D file or describe your project using our online form. Our team will review your submission and reach out if we need more details.
                            <a href="<?= url('/quote') ?>" class="text-yellow-500 font-semibold">Get a Quote</a> and we will guide you through the process.
                        </p>
                    </div>
                </div>
            </div>
            <!-- How to Order Steps (Alpine.js Loop) -->
            <div x-data="{
                steps: [
                    {
                        number: 2,
                        icon: `<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='h-12 w-12'><path stroke-linecap='round' stroke-linejoin='round' d='M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z' /></svg>`,
                        title: 'Receive a Quote & Approve',
                        desc: 'We’ll send you a detailed quote based on your design, material, and finish preferences. Review and approve the quote to start production.'
                    },
                    {
                        number: 3,
                        icon: `<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='h-12 w-12'><path stroke-linecap='round' stroke-linejoin='round' d='M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z' /></svg>`,
                        title: 'Printing & Quality Check',
                        desc: 'Your part is printed using our professional machines. Every order is inspected for quality and accuracy before shipping or pickup.'
                    },
                    {
                        number: 4,
                        icon: `<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='h-12 w-12'><path stroke-linecap='round' stroke-linejoin='round' d='M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12' /></svg>`,
                        title: 'Delivery or Pickup',
                        desc: 'We ship your finished part securely to your address, or you can choose to pick it up at our workshop. Enjoy your custom 3D print!'
                    }
                ]
            }">
                <template x-for="(step, idx) in steps" :key="step.number">
                    <div class="flex relative pb-20 sm:items-center md:w-2/3 mx-auto" :class="{'pb-10': idx === steps.length - 1}">
                        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                            <div class="h-full w-1 bg-gray-800 pointer-events-none"></div>
                        </div>
                        <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-yellow-500 text-gray-900 relative z-10 title-font font-semibold text-sm" x-text="step.number"></div>
                        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                            <div class="flex-shrink-0 w-24 h-24 bg-gray-800 text-yellow-500 rounded-full inline-flex items-center justify-center">
                                <span x-html="step.icon"></span>
                            </div>
                            <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                                <h2 class="font-medium title-font text-white mb-1 text-xl" x-text="step.title"></h2>
                                <p class="leading-relaxed" x-text="step.desc"></p>
                            </div>
                        </div>
                    </div>
                </template>
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