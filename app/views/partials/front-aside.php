<aside class="w-64 bg-white shadow hidden md:block">
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-2">Calendar</h2>
        <!-- Calendar placeholder -->
        <div x-data="{ month: 'July', year: 2025 }" class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <button class="text-gray-500">&lt;</button>
                <span x-text="month + ' ' + year"></span>
                <button class="text-gray-500">&gt;</button>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center text-xs">
                <template x-for="day in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']" :key="day">
                    <div class="font-bold" x-text="day"></div>
                </template>
                <!-- Days would be rendered here dynamically -->
            </div>
        </div>
        <h2 class="text-lg font-semibold mb-2">Ongoing Events</h2>
        <ul>
            <?php if (!empty($ongoing_events)): foreach ($ongoing_events as $event): ?>
                    <li class="mb-2">
                        <a href="/event/<?= $event->id ?>" class="text-blue-600 hover:underline">
                            <?= htmlspecialchars($event->title) ?>
                        </a>
                    </li>
                <?php endforeach;
            else: ?>
                <li class="text-gray-500">No ongoing events.</li>
            <?php endif; ?>
        </ul>
    </div>
</aside>