<div class="max-w-8xl mx-auto p-8">
    <h1 class="text-3xl font-extrabold text-blue-900 mb-8">Quote Details</h1>
    <?php if (!$quote): ?>
        <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded-lg mb-6">Quote not found.</div>
    <?php else: ?>
        <div class="flex flex-col gap-6">
            <!-- Customer Information Card -->
            <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0 flex flex-col items-center md:items-start w-full md:w-1/3">
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                            <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z" />
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-blue-900 text-center md:text-left"><?= e($quote->name) ?></div>
                    <div class="text-blue-400 text-sm text-center md:text-left mb-2">Customer</div>
                </div>
                <div class="flex-1 grid grid-cols-1 gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-blue-700 font-semibold">Email:</span>
                        <a href="mailto:<?= e($quote->email) ?>" class="text-blue-600 hover:underline font-semibold"><?= e($quote->email) ?></a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-700 font-semibold">Phone:</span>
                        <a href="tel:<?= e($quote->phone) ?>" class="text-blue-600 hover:underline font-semibold"><?= e($quote->phone) ?></a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-700 font-semibold">Instagram:</span>
                        <?php if ($quote->instagram): ?>
                            <a href="https://instagram.com/<?= e($quote->instagram) ?>" target="_blank" class="text-pink-500 hover:underline font-semibold">@<?= e($quote->instagram) ?></a>
                        <?php else: ?>
                            <span class="text-blue-300">-</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-blue-700 font-semibold">Delivery:</span>
                        <span class="text-blue-900"><?= e($quote->delivery_address) ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-700 font-semibold">Billing:</span>
                        <span class="text-blue-900"><?= e($quote->billing_address) ?></span>
                    </div>
                </div>
            </div>

            <!-- Project Specifics Card -->
            <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6 flex flex-col gap-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <path d="M2 7h20" />
                    </svg>
                    <span class="font-semibold text-blue-900">Project Specifics</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-blue-700 font-semibold">Product Type:</span>
                        <span class="text-blue-900"><?= e($quote->product_type) ?></span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-semibold">Material:</span>
                        <span class="text-blue-900"><?= e($quote->material) ?></span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-semibold">Quantity:</span>
                        <span class="text-blue-900"><?= e($quote->quantity) ?></span>
                    </div>
                    <div>
                        <span class="text-blue-700 font-semibold">Timeline:</span>
                        <span class="text-blue-900"><?= e($quote->timeline) ?></span>
                    </div>
                </div>
                <div>
                    <span class="text-blue-700 font-semibold">Description:</span>
                    <div class="text-blue-800 bg-blue-50 rounded p-3 mt-1 border border-blue-100 text-sm"><?= nl2br(e($quote->description)) ?></div>
                </div>
            </div>

            <!-- Additional Services & Budget Card -->
            <div class="bg-white rounded-xl shadow-md border border-blue-100 p-6 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                    <span class="font-semibold text-blue-900">Additional Services & Budget</span>
                </div>
                <div>
                    <span class="text-blue-700 font-semibold">Services:</span>
                    <span class="text-blue-900"><?= e(implode(', ', (array)($quote->services ?? []))) ?></span>
                </div>
                <div>
                    <span class="text-blue-700 font-semibold">Budget:</span>
                    <span class="text-blue-900"><?= e($quote->budget) ?></span>
                </div>
                <div>
                    <span class="text-blue-700 font-semibold">Submitted:</span>
                    <span class="text-blue-900"><?= e($quote->created_at ?? '-') ?></span>
                </div>
            </div>

            <div class="flex items-center mt-6">
                <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-4 py-2 font-semibold transition shadow-sm" onclick="return confirm('Delete this quote?')">Delete</button>
                </form>
                <a href="<?= url('admin/quotes') ?>" class="ml-4 bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-4 py-2 font-semibold transition shadow-sm">Back to Quotes</a>
            </div>
        </div>
    <?php endif; ?>
</div>