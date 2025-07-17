<div class="bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-2">Ongoing Events</h2>
    <?php if (!empty($ongoing_events)): ?>
        <ul class="space-y-1">
            <?php foreach ($ongoing_events as $event): ?>
                <li class="text-sm text-gray-700">
                    <?= htmlspecialchars(is_object($event) ? $event->title : ($event['title'] ?? '')) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-400 text-sm">No ongoing events.</p>
    <?php endif; ?>
</div>