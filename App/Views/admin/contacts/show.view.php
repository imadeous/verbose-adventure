<?php $this->layout('admin'); ?>

<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Contact Message</h1>
        <a href="<?= url('admin/contacts') ?>" class="text-sm text-blue-600 hover:underline">&larr; Back to list</a>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4 flex items-center space-x-3">
            <div class="flex-shrink-0 bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center text-blue-600 font-bold uppercase text-xl">
                <?= strtoupper(mb_substr($contact->name, 0, 1)) ?>
            </div>
            <div>
                <div class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($contact->name) ?></div>
                <div class="text-xs text-gray-500">Email: <a href="mailto:<?= htmlspecialchars($contact->email) ?>" class="hover:underline text-blue-600"><?= htmlspecialchars($contact->email) ?></a></div>
                <div class="text-xs text-gray-500">Sent: <?= htmlspecialchars(date('Y-m-d H:i', strtotime($contact->created_at))) ?></div>
            </div>
        </div>
        <div class="mb-4">
            <div class="text-xs text-gray-500 mb-1">Message:</div>
            <div class="bg-gray-50 border border-gray-200 rounded p-4 text-gray-800 whitespace-pre-line">
                <?= nl2br(htmlspecialchars($contact->message)) ?>
            </div>
        </div>
        <?php if ($contact->opened_at): ?>
            <div class="text-xs text-green-600">Opened: <?= htmlspecialchars(date('Y-m-d H:i', strtotime($contact->opened_at))) ?></div>
        <?php endif; ?>
        <div class="mt-6 flex justify-end">
            <form action="<?= url('admin/contacts/' . $contact->id . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this contact?')">
                <input type="hidden" name="_method" value="DELETE">
                <?= csrf_field() ?>
                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded text-sm border border-red-200 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>