<div class="w-full h-screen flex flex-col">
    <!-- Gmail-style header -->
    <div class="shrink-0 px-4 py-4 border-b border-gray-200 bg-white">
        <div class="flex justify-between items-center">
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

    <!-- Split view container -->
    <div class="flex-1 flex overflow-hidden">
        <!-- Sidebar: Message list -->
        <div class="w-80 lg:w-96 shrink-0 border-r border-gray-200 bg-white overflow-y-auto">
            <?php if (empty($contacts)): ?>
                <div class="px-6 py-20 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <p class="text-gray-500 text-lg">No messages</p>
                    <p class="text-gray-400 text-sm mt-1">Your inbox is empty</p>
                </div>
            <?php else: ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($contacts as $contact): ?>
                        <?php
                        $isSelected = isset($selectedContact) && $selectedContact->id == $contact->id;
                        ?>
                        <div class="<?= $isSelected ? 'bg-blue-100 border-l-4 border-l-blue-600' : (is_null($contact->opened_at) ? 'bg-blue-50' : 'bg-white hover:bg-gray-50') ?>">
                            <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="block px-3 py-3 cursor-pointer">
                                <div class="flex items-start gap-2">
                                    <!-- Unread indicator -->
                                    <div class="shrink-0 mt-1.5">
                                        <?php if (is_null($contact->opened_at)): ?>
                                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                        <?php else: ?>
                                            <div class="w-2 h-2"></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <!-- Sender name -->
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="<?= is_null($contact->opened_at) ? 'font-bold text-gray-900' : 'font-medium text-gray-700' ?> truncate text-sm">
                                                <?= e($contact->name) ?>
                                            </div>
                                            <span class="text-xs text-gray-500 ml-2 shrink-0">
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
                                        </div>

                                        <!-- Email -->
                                        <div class="text-xs text-gray-500 truncate mb-1"><?= e($contact->email) ?></div>

                                        <!-- Message preview -->
                                        <p class="text-sm text-gray-600 truncate">
                                            <?= e(mb_strimwidth($contact->message, 0, 80, '...')) ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Main content: Message viewer -->
        <div class="flex-1 bg-gray-50 overflow-y-auto">
            <?php if (isset($selectedContact)): ?>
                <!-- Message detail view -->
                <div class="max-w-4xl mx-auto px-6 py-6">
                    <!-- Message header -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-4">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="shrink-0 bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center text-blue-600 font-bold uppercase text-xl">
                                    <?= strtoupper(mb_substr($selectedContact->name, 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 text-lg"><?= e($selectedContact->name) ?></div>
                                    <div class="text-sm text-gray-600">
                                        <a href="mailto:<?= e($selectedContact->email) ?>" class="hover:underline text-blue-600"><?= e($selectedContact->email) ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">
                                    <?= date('M j, Y \a\t g:i A', strtotime($selectedContact->created_at)) ?>
                                </div>
                                <?php if ($selectedContact->opened_at): ?>
                                    <div class="text-xs text-green-600 mt-1">
                                        ✓ Opened <?= date('M j \a\t g:i A', strtotime($selectedContact->opened_at)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Message body -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="text-gray-800 whitespace-pre-line leading-relaxed">
                            <?= nl2br(e($selectedContact->message)) ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="mailto:<?= e($selectedContact->email) ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                            </svg>
                            Reply
                        </a>
                        <form action="<?= url('admin/contacts/' . $selectedContact->id . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this message? This action cannot be undone.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors border border-red-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Empty state when no message selected -->
                <div class="h-full flex items-center justify-center">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-24 h-24 mx-auto text-gray-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">No message selected</p>
                        <p class="text-gray-400 text-sm mt-1">Choose a message from the list to view it here</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>