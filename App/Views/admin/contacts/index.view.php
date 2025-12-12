<div class="w-full max-w-full px-2 sm:px-4 py-6 mx-auto">
    <!-- Gmail-style header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-normal text-gray-900 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            Inbox
        </h1>
        <div class="text-sm text-gray-600">
            <?php
            $unreadCount = 0;
            foreach ($contacts as $contact) {
                if (is_null($contact->opened_at)) $unreadCount++;
            }
            ?>
            <?php if ($unreadCount > 0): ?>
                <span class="font-medium text-blue-600"><?= $unreadCount ?> unread</span>
                <span class="text-gray-400 mx-1">·</span>
            <?php endif; ?>
            <span><?= count($contacts) ?> total</span>
        </div>
    </div>
</div>

<!-- Gmail-style message list -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <?php if (empty($contacts)): ?>
        <div class="px-6 py-20 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            <p class="text-gray-500 text-lg">No messages in your inbox</p>
            <p class="text-gray-400 text-sm mt-1">Messages will appear here when customers contact you</p>
        </div>
    <?php else: ?>
        <div class="divide-y divide-gray-100">
            <?php foreach ($contacts as $contact): ?>
                <div class="group hover:shadow-md transition-all duration-150 <?= is_null($contact->opened_at) ? 'bg-blue-50' : 'bg-white hover:bg-gray-50' ?>">
                    <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="flex items-center px-4 py-3 cursor-pointer">
                        <!-- Star/Important marker (placeholder) -->
                        <div class="shrink-0 mr-3">
                            <?php if (is_null($contact->opened_at)): ?>
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            <?php else: ?>
                                <div class="w-2 h-2"></div>
                            <?php endif; ?>
                        </div>

                        <!-- Sender info -->
                        <div class="shrink-0 w-48 mr-4">
                            <div class="<?= is_null($contact->opened_at) ? 'font-bold text-gray-900' : 'font-medium text-gray-700' ?> truncate">
                                <?= e($contact->name) ?>
                            </div>
                            <div class="text-xs text-gray-500 truncate"><?= e($contact->email) ?></div>
                        </div>

                        <!-- Message preview -->
                        <div class="flex-1 min-w-0 mr-4">
                            <p class="<?= is_null($contact->opened_at) ? 'font-semibold text-gray-900' : 'text-gray-700' ?> truncate">
                                <?= e(mb_strimwidth($contact->message, 0, 100, '...')) ?>
                            </p>
                        </div>

                        <!-- Date and actions -->
                        <div class="shrink-0 flex items-center gap-3">
                            <span class="text-xs text-gray-500">
                                <?php
                                $date = new DateTime($contact->created_at);
                                $now = new DateTime();
                                $diff = $now->diff($date);

                                if ($diff->days == 0) {
                                    echo $date->format('g:i A');
                                } elseif ($diff->days < 7) {
                                    echo $date->format('D');
                                } else {
                                    echo $date->format('M j');
                                }
                                ?>
                            </span>

                            <!-- Action buttons (visible on hover) -->
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <?php if (!is_null($contact->opened_at)): ?>
                                    <form action="<?= url('admin/contacts/' . $contact->id . '/delete') ?>" method="POST" onclick="event.stopPropagation();">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="p-1.5 hover:bg-gray-200 rounded-full transition" title="Delete" onclick="return confirm('Delete this message?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>