<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quote Details</h1>
    <?php if (!$quote): ?>
        <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-4">Quote not found.</div>
    <?php else: ?>
        <div class="flex flex-col gap-6">
            <!-- Customer Information Card -->
            <div class="bg-white shadow rounded-xl p-6 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0 flex flex-col items-center md:items-start w-full md:w-1/3">
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                            <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z" />
                        </svg>
                    </div>
                    <div class="text-lg font-bold text-gray-800 text-center md:text-left"><?= e($quote->name) ?></div>
                    <div class="text-gray-500 text-sm text-center md:text-left mb-2">Customer</div>
                </div>
                <div class="flex-1 grid grid-cols-1 gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600 font-semibold">Email:</span>
                        <a href="mailto:<?= e($quote->email) ?>" class="text-blue-600 hover:underline"><?= e($quote->email) ?></a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600 font-semibold">Phone:</span>
                        <a href="tel:<?= e($quote->phone) ?>" class="text-blue-600 hover:underline"><?= e($quote->phone) ?></a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600 font-semibold">Instagram:</span>
                        <?php if ($quote->instagram): ?>
                            <a href="https://instagram.com/<?= e($quote->instagram) ?>" target="_blank" class="text-pink-500 hover:underline">@<?= e($quote->instagram) ?></a>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87M16 3.13a4 4 0 0 1 0 7.75M8 3.13a4 4 0 0 0 0 7.75" />
                        </svg>
                        <span class="text-gray-600 font-semibold">Delivery:</span>
                        <span class="text-gray-700"><?= e($quote->delivery_address) ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600 font-semibold">Billing:</span>
                        <span class="text-gray-700"><?= e($quote->billing_address) ?></span>
                    </div>
                </div>
            </div>

            <!-- Project Specifics Card -->
            <div class="bg-white shadow rounded-xl p-6 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <path d="M2 7h20" />
                    </svg>
                    <span class="font-semibold text-gray-700">Project Specifics</span>
                </div>
                <div class="flex flex-wrap gap-4">
                    <div><span class="text-gray-600 font-semibold">Product Type:</span> <span class="text-gray-700"><?= e($quote->product_type) ?></span></div>
                    <div><span class="text-gray-600 font-semibold">Material:</span> <span class="text-gray-700"><?= e($quote->material) ?></span></div>
                    <div><span class="text-gray-600 font-semibold">Quantity:</span> <span class="text-gray-700"><?= e($quote->quantity) ?></span></div>
                    <div><span class="text-gray-600 font-semibold">Timeline:</span> <span class="text-gray-700"><?= e($quote->timeline) ?></span></div>
                </div>
                <div class="mt-2">
                    <span class="text-gray-600 font-semibold">Description:</span>
                    <div class="text-gray-700 bg-gray-50 rounded p-2 mt-1 border border-gray-100 text-sm"><?= nl2br(e($quote->description)) ?></div>
                </div>
            </div>

            <!-- Additional Services & Budget Card -->
            <div class="bg-white shadow rounded-xl p-6 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                    <span class="font-semibold text-gray-700">Additional Services & Budget</span>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold">Services:</span>
                    <span class="text-gray-700"><?= e(implode(', ', (array)($quote->services ?? []))) ?></span>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold">Budget:</span>
                    <span class="text-gray-700"><?= e($quote->budget) ?></span>
                </div>
                <div>
                    <span class="text-gray-600 font-semibold">Submitted:</span>
                    <span class="text-gray-700"><?= e($quote->created_at ?? '-') ?></span>
                </div>
            </div>

            <div class="flex items-center mt-4">
                <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this quote?')">Delete</button>
                </form>
                <a href="<?= url('admin/quotes') ?>" class="ml-4 text-blue-600 hover:underline">Back to Quotes</a>
            </div>
        </div>
    <?php endif; ?>
</div>