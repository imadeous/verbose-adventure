<?php if (!empty($upcomingEvents)): ?>
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-blue-700 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10" />
            </svg>
            Upcoming Events
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($upcomingEvents as $event): ?>
                <?php include __DIR__ . '/_event-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>