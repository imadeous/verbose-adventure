<header class="text-gray-400 bg-gray-900 body-font" x-data="{
    current: window.location.pathname.replace(/\/$/, ''),
    isActive(path) {
        // Remove trailing slash for comparison
        return this.current === path.replace(/\/$/, '');
    }
}">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a href="<?= url('/') ?>" class="flex title-font font-medium items-center text-white mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-yellow-500 rounded-full" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl">Craftophile Shop</span>
        </a>
        <nav class="md:ml-auto md:mr-auto hidden md:flex flex-wrap items-center text-base justify-center">
            <a href="<?= url('/gallery') ?>" :class="isActive('<?= parse_url(url('/gallery'), PHP_URL_PATH) ?>') ? 'text-yellow-500 mr-5' : 'mr-5 hover:text-white'">Gallery</a>
            <a href="<?= url('/quote') ?>" :class="isActive('<?= parse_url(url('/quote'), PHP_URL_PATH) ?>') ? 'text-yellow-500 mr-5' : 'mr-5 hover:text-white'">Get Quote</a>
            <a href="<?= url('/about') ?>" :class="isActive('<?= parse_url(url('/about'), PHP_URL_PATH) ?>') ? 'text-yellow-500 mr-5' : 'mr-5 hover:text-white'">About Us</a>
            <a href="<?= url('/contact') ?>" :class="isActive('<?= parse_url(url('/contact'), PHP_URL_PATH) ?>') ? 'text-yellow-500 mr-5' : 'mr-5 hover:text-white'">Contact</a>
        </nav>
        <span class="flex items-center space-x-1">
            <span class="text-sm hidden md:inline">Follow us on:</span>
            <a href="https://www.instagram.com/craftophile_mv" target="new" class="inline-flex items-center space-x-1 text-yellow-500 bg-gray-800 border-0 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base mt-4 md:mt-0">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                </svg>
                <span>MV</span>
            </a>
            <a href="https://www.instagram.com/craftophile_fnd" target="new" class="inline-flex items-center space-x-1 text-yellow-500 bg-gray-800 border-0 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base mt-4 md:mt-0">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                </svg>
                <span>FND</span>
            </a>
        </span>
    </div>
</header>
<!-- Responsive Bottom App Bar for Mobile -->
<div x-data="{
    current: window.location.pathname.replace(/\/$/, ''),
    isActive(path) {
        return this.current === path.replace(/\/$/, '');
    }
}" class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 border-t border-gray-800 flex justify-around items-center py-2 md:hidden">
    <a href="<?= url('/gallery') ?>" class="flex flex-col items-center text-xs" :class="isActive('<?= parse_url(url('/gallery'), PHP_URL_PATH) ?>') ? 'text-yellow-500' : 'text-gray-400'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
        </svg>
        Gallery
    </a>
    <a href="<?= url('/quote') ?>" class="flex flex-col items-center text-xs" :class="isActive('<?= parse_url(url('/quote'), PHP_URL_PATH) ?>') ? 'text-yellow-500' : 'text-gray-400'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
        </svg>
        Quote
    </a>
    <a href="<?= url('/about') ?>" class="flex flex-col items-center text-xs" :class="isActive('<?= parse_url(url('/about'), PHP_URL_PATH) ?>') ? 'text-yellow-500' : 'text-gray-400'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
        </svg>
        About
    </a>
    <a href="<?= url('/contact') ?>" class="flex flex-col items-center text-xs" :class="isActive('<?= parse_url(url('/contact'), PHP_URL_PATH) ?>') ? 'text-yellow-500' : 'text-gray-400'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
        </svg>
        Contact
    </a>
</div>