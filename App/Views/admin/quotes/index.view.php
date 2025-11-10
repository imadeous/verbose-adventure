<div class="max-w-8xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-blue-900">Quotes</h1>

        <!-- Bulk Actions -->
        <div x-data="{ 
            selectedQuotes: [], 
            showActions: false,
            toggleSelectAll(event) {
                const checkboxes = document.querySelectorAll('.quote-checkbox');
                const isChecked = event.target.checked;
                
                this.selectedQuotes = [];
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    if (isChecked) {
                        this.selectedQuotes.push(parseInt(checkbox.value));
                    }
                });
            },
            updateSelection(event, quoteId) {
                if (event.target.checked) {
                    if (!this.selectedQuotes.includes(quoteId)) {
                        this.selectedQuotes.push(quoteId);
                    }
                } else {
                    this.selectedQuotes = this.selectedQuotes.filter(id => id !== quoteId);
                    document.getElementById('selectAll').checked = false;
                }
            },
            updateSelectAll() {
                document.getElementById('selectAll').checked = false;
                document.querySelectorAll('.quote-checkbox').forEach(cb => cb.checked = false);
                this.selectedQuotes = [];
            },
            bulkDelete() {
                if (this.selectedQuotes.length === 0) {
                    alert('Please select quotes to delete.');
                    return;
                }
                
                if (confirm(`Are you sure you want to delete ${this.selectedQuotes.length} selected quote(s)? This action cannot be undone.`)) {
                    document.getElementById('bulkAction').value = 'delete';
                    document.getElementById('selectedQuoteIds').value = this.selectedQuotes.join(',');
                    document.getElementById('bulkForm').submit();
                }
            },
            markAsRead() {
                if (this.selectedQuotes.length === 0) {
                    alert('Please select quotes to mark as read.');
                    return;
                }
                
                document.getElementById('bulkAction').value = 'mark_read';
                document.getElementById('selectedQuoteIds').value = this.selectedQuotes.join(',');
                document.getElementById('bulkForm').submit();
            }
        }" x-init="$watch('selectedQuotes', value => showActions = value.length > 0)">
            <div x-show="showActions" x-transition class="flex items-center space-x-3">
                <span class="text-sm text-gray-600">
                    <span x-text="selectedQuotes.length"></span> selected
                </span>
                <button @click="bulkDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Delete Selected
                </button>
                <button @click="markAsRead()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Mark as Read
                </button>
                <button @click="selectedQuotes = []; updateSelectAll()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm transition">
                    Cancel
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
                <form id="bulkForm" action="<?= url('admin/quotes/bulk-action') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" id="bulkAction" value="">
                    <input type="hidden" name="quote_ids" id="selectedQuoteIds" value="">

                    <table class="min-w-full bg-white rounded-xl text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">
                                    <input type="checkbox" id="selectAll" @change="toggleSelectAll($event)" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Name & Email</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Product</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200 hidden md:table-cell">Submitted</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($quotes)): ?>
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-blue-400">No quotes found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($quotes as $quote): ?>
                                    <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                                        <td class="px-4 py-2">
                                            <input type="checkbox"
                                                class="quote-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                value="<?= $quote->id ?>"
                                                @change="updateSelection($event, <?= $quote->id ?>)">
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <div class="font-semibold text-blue-900"><?= e($quote->name) ?></div>
                                            <div class="text-blue-500 text-xs"><?= e($quote->email) ?></div>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-blue-700 hidden md:table-cell"><?= e($quote->product_type) ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-blue-400 text-xs hidden md:table-cell"><?= e($quote->created_at ?? '-') ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                                            <a href="<?= url('admin/quotes/' . $quote->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                            <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="Delete" onclick="return confirm('Delete this quote?')">
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
                </form>
            </div>
        </div>
    </div>
</div>