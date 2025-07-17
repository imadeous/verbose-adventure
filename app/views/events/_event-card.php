<div class="bg-gradient-to-br from-green-900 via-green-800 to-green-700 border border-green-900 rounded-2xl hover:shadow-lg transition-shadow duration-200 overflow-hidden flex flex-col">
    <!-- Banner/Logo Top Section -->
    <div class="relative h-32 bg-white rounded-bl-4xl flex items-end">
        <?php if (!empty($event->banner)): ?>
            <span>BANNER</span>
            <img src="<?= htmlspecialchars($event->banner) ?>" alt="Event Banner" class="absolute inset-0 w-full h-full object-cover opacity-60" />
        <?php endif; ?>
        <div class="relative z-10 mb-[-2rem] ml-6 flex items-end">
            <div class="w-24 h-24 rounded-full bg-white border-3 border-white flex items-center justify-center shadow-md overflow-hidden">
                <?php if (!empty($event->logo)): ?>
                    <img src="<?= htmlspecialchars($event->logo) ?>" alt="Logo" class="w-14 h-14 object-contain rounded-full" />
                <?php else: ?>
                    <span class="text-green-400 text-2xl font-bold">LOGO</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="flex-1 flex flex-col pt-12 pb-5 px-5">
        <h2 class="text-lg font-bold text-white mb-2 truncate" title="<?= htmlspecialchars($event->title) ?>">
            <?= htmlspecialchars($event->title) ?>
        </h2>
        <?php if (!empty($event->introduction)): ?>
            <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                <?= htmlspecialchars(mb_strimwidth(strip_tags($event->introduction), 0, 120, '...')) ?>
            </p>
        <?php else: ?>
            <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                <?= htmlspecialchars(mb_strimwidth(strip_tags($event->details), 0, 120, '...')) ?>
            </p>
        <?php endif; ?>
        <div class="mt-auto flex flex-col gap-2">
            <div class="flex items-center text-green-200 text-xs gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <?= date('F j, Y', strtotime($event->start_date)) ?>
                &ndash; <?= date('F j, Y', strtotime($event->end_date)) ?>

            </div>
            <div class="flex items-center text-green-200 text-xs gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <?= $event->venue ?>
            </div>
            <div class="flex justify-end">
                <a href="<?= url('/events/' . $event->id) ?>"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 via-green-700 to-green-800 text-white font-semibold px-5 py-2 rounded-full shadow ring-1 ring-green-400/30 hover:from-green-700 hover:to-green-900 hover:scale-105 transition-all duration-150 mt-2">
                    Discover More
                    <svg class="w-4 h-4 ml-1 text-white opacity-80 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>