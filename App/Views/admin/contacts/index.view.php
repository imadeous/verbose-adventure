<?php $this->layout('admin'); ?>

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Contact Messages</h1>
    <?php if (empty($contacts)): ?>
        <div class="text-gray-400">No contact messages found.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Message</th>
                        <th class="px-4 py-2 text-left">Created At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="px-4 py-2"><?= htmlspecialchars($contact->id) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($contact->name) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($contact->email) ?></td>
                            <td class="px-4 py-2 max-w-xs truncate" title="<?= htmlspecialchars($contact->message) ?>">
                                <?= htmlspecialchars(mb_strimwidth($contact->message, 0, 50, '...')) ?>
                            </td>
                            <td class="px-4 py-2"><?= htmlspecialchars($contact->created_at) ?></td>
                            <td class="px-4 py-2">
                                <a href="<?= url('/admin/contacts/' . $contact->id) ?>" class="text-yellow-400 hover:underline mr-2">View</a>
                                <form action="<?= url('/admin/contacts/' . $contact->id) ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete this contact?')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-red-400 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>