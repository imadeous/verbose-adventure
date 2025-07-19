<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
    </div>
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No contact messages found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="hover:underline">
                                    <?= htmlspecialchars($contact->id) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= htmlspecialchars($contact->name) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= htmlspecialchars($contact->email) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 max-w-xs truncate" title="<?= htmlspecialchars($contact->message) ?>">
                                <?= htmlspecialchars(mb_strimwidth($contact->message, 0, 50, '...')) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?= htmlspecialchars($contact->created_at) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-2">
                                <a href="<?= url('admin/contacts/' . $contact->id) ?>" class="text-yellow-600 hover:underline" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9m7.5 0v10.5A2.25 2.25 0 0 1 13.5 21h-3A2.25 2.25 0 0 1 8.25 19.5V9m7.5 0h-9" />
                                    </svg>
                                </a>
                                <form action="<?= url('admin/contacts/' . $contact->id) ?>" method="POST" style="display:inline;" onsubmit="return confirm('Delete this contact?')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-red-600 hover:underline" title="Delete">
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
</div>