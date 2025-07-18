<aside x-show="sidebar" class="h-screen z-50 bg-gray-900 lg:w-72 absolute md:relative inset-0 py-4 px-3"
    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
    <div class="h-full flex flex-col justify-around space-y-4">
        <div class="flex justify-between items-center mb-8">
            <div class="">
                <a href="#" class="uppercase text-2xl text-gray-300 tracking-tight font-bold px-4">
                    <?= getenv('APP_NAME') ?: 'Dashboard' ?>
                </a>
            </div>
            <button @click="sidebar = false" class="lg:hidden text-gray-100 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col justify-between h-full">
            <div class="text-gray-500 tracking-6 font-semibold">
                <ul class="space-y-1">
                    <li class="text-gray-200 bg-gray-800 rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <a href="<?= url('admin') ?>" class="w-full">Dashboard</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10" />
                        </svg>
                        <a href="<?= url('admin/quotes') ?>" class="w-full">Quotes</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c0 7.489-8.25 11.739-8.25 11.739S3.75 16 3.75 8.511A6.75 6.75 0 0 1 12 1.75a6.75 6.75 0 0 1 8.25 6.761Z" />
                        </svg>
                        <a href="<?= url('admin/products') ?>" class="w-full">Products</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <a href="<?= url('admin/categories') ?>" class="w-full">Categories</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <a href="<?= url('admin/gallery') ?>" class="w-full">Gallery</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <a href="<?= url('admin/contacts') ?>" class="w-full">Contacts</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                        </svg>
                        <a href="<?= url('admin/transactions') ?>" class="w-full">Transactions</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" />
                        </svg>
                        <a href="<?= url('admin/reviews') ?>" class="w-full">Reviews</a>
                    </li>
                    <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm-8 8a8 8 0 1 1 16 0 8 8 0 0 1-16 0Z" />
                        </svg>
                        <a href="<?= url('admin/promo-codes') ?>" class="w-full">Promo Codes</a>
                    </li>

                    <?php

                    use App\Helpers\Auth;

                    if (Auth::isAdmin()) : ?>
                        <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            <a href="<?= url('admin/fund') ?>" class="w-full">Fund</a>
                        </li>
                        <li class="hover:text-white rounded px-4 py-3 flex space-x-4 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <a href="<?= url('admin/users') ?>" class="w-full">Users</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
            <!-- Quick Links and other sidebar sections can be added here as needed -->
        </div>
    </div>
</aside>