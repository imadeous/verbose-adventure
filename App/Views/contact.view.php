<section class="text-gray-400 bg-gray-900 body-font relative">
    <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
        <div class="lg:w-2/3 md:w-1/2 bg-gray-900 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
            <!-- <iframe width="100%" height="100%" title="map" class="absolute inset-0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=%C4%B0zmir+(My%20Business%20Name)&ie=UTF8&t=&z=14&iwloc=B&output=embed" style="filter: grayscale(1) contrast(1.2) opacity(0.16);"></iframe> -->
            <div style="text-decoration:none; overflow:hidden;max-width:100%;width:500px;height:500px;">
                <div id="display-google-map" class="absolute inset-0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" style="height:100%; width:100%;max-width:100%;"><iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=572Q+PXC,+Chanbeyleemagu+Rd,+Funadhoo+03105,+Maldives&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe></div><a class="my-codefor-googlemap" href="https://www.bootstrapskins.com/themes" id="authorize-maps-data">premium bootstrap themes</a>
                <style>
                    #display-google-map img.text-marker {
                        max-width: none !important;
                        background: none !important;
                    }

                    img {
                        max-width: none
                    }
                </style>
            </div>
            <div class="bg-gray-900 relative flex flex-wrap py-6 rounded shadow-md">
                <div class="lg:w-1/2 px-6">
                    <h2 class="title-font font-semibold text-white tracking-widest text-xs">ADDRESS</h2>
                    <p class="mt-1">Aman, Funadhoo,<br>03150, Maldives</p>
                </div>
                <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                    <h2 class="title-font font-semibold text-white tracking-widest text-xs">EMAIL</h2>
                    <a href="mailto:hello@craftophile.com" class="text-yellow-400 leading-relaxed">hello@craftophile.com</a>
                    <h2 class="title-font font-semibold text-white tracking-widest text-xs mt-4">PHONE</h2>
                    <p class="leading-relaxed">(960) 980-0303</p>
                </div>
            </div>
        </div>
        <div class="lg:w-1/3 md:w-1/2 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
            <h2 class="text-white text-lg mb-1 font-medium title-font">Contact Us</h2>
            <p class="leading-relaxed mb-5">Have a question, need a quote, or want to discuss your next project? Fill out the form below and our team will get back to you as soon as possible.</p>
            <?= $this->partial('_flash.view'); ?>
            <form method="POST" action="/contact" autocomplete="off">
                <?= csrf_field() ?>
                <div class="relative mb-4">
                    <label for="name" class="leading-7 text-sm text-gray-400">Name</label>
                    <input type="text" id="name" name="name" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                </div>
                <div class="relative mb-4">
                    <label for="email" class="leading-7 text-sm text-gray-400">Email</label>
                    <input type="email" id="email" name="email" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                </div>
                <div class="relative mb-4">
                    <label for="message" class="leading-7 text-sm text-gray-400">Message</label>
                    <textarea id="message" name="message" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-900 h-32 text-base outline-none text-gray-100 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" required></textarea>
                </div>
                <button type="submit" class="text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg">Send Message</button>
            </form>
            <p class="text-xs text-gray-400 text-opacity-90 mt-3">We respect your privacy. Your information will only be used to respond to your inquiry.</p>
        </div>
    </div>
</section>