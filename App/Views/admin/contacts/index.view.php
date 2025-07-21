<div class="w-full max-w-full px-2 sm:px-4 py-8 mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
    </div>
    <style>
        /* Make the message column take all available space */
        .contacts-table-message-col {
            width: 100%;
        }
    </style>
</div>
<div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl text-sm">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Sender</th>
                <th class="contacts-table-message-col px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Message</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($contacts)): ?>
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-blue-400">No contacts found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($contacts as $contact): ?>
                    <tr class="border-t border-blue-100 hover:bg-blue-50 transition <?= is_null($contact->opened_at) ? ' bg-yellow-50' : '' ?>">
                        <td class="px-4 py-2 whitespace-nowrap ">
                            <div class="font-semibold text-blue-900"><?= e($contact->name) ?></div>
                            <div class="text-blue-500 text-xs"><?= e($contact->email) ?></div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-blue-700 <?= is_null($contact->opened_at) ? 'font-semibold' : '' ?>">
                            <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="block"><?= e(mb_strimwidth($contact->message, 0, 100, '...')) ?></a>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                            <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>
                            <form action="<?= url('admin/contacts/' . $contact->id . '/delete') ?>" method="POST" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Delete" onclick="return confirm('Delete this contact message?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>