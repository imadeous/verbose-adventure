<?php if (!empty($pastEvents)): ?>
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-600 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Past Events
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($pastEvents as $event): ?>
                <?php include __DIR__ . '/_event-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>