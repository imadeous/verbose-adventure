<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quote Details</h1>
    <?php if (!$quote): ?>
        <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-4">Quote not found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Customer Details & Addresses -->
                <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col gap-2">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                            <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z" />
                        </svg>
                        <span class="font-semibold text-gray-700">Customer</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Name:</span> <span class="font-medium"><?= e($quote->name) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Email:</span> <span class="font-medium"><?= e($quote->email) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Phone:</span> <span class="font-medium"><?= e($quote->phone) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Instagram:</span> <span class="font-medium"><?= e($quote->instagram) ?></span>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87M16 3.13a4 4 0 0 1 0 7.75M8 3.13a4 4 0 0 0 0 7.75" />
                        </svg>
                        <span class="font-semibold text-gray-700">Addresses</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Delivery:</span>
                        <span class="font-medium"><?= e($quote->delivery_address) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Billing:</span>
                        <span class="font-medium"><?= e($quote->billing_address) ?></span>
                    </div>
                </div>

                <!-- Project Details -->
                <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col gap-2">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <path d="M2 7h20" />
                        </svg>
                        <span class="font-semibold text-gray-700">Project Details</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Product Type:</span> <span class="font-medium"><?= e($quote->product_type) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Material:</span> <span class="font-medium"><?= e($quote->material) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Quantity:</span> <span class="font-medium"><?= e($quote->quantity) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Timeline:</span> <span class="font-medium"><?= e($quote->timeline) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Description:</span>
                        <div class="text-gray-700 bg-white rounded p-2 mt-1 border border-gray-100"><?= nl2br(e($quote->description)) ?></div>
                    </div>
                </div>

                <!-- Additional Services & Budget -->
                <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col gap-2">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4l3 3" />
                        </svg>
                        <span class="font-semibold text-gray-700">Additional Info</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Services:</span>
                        <span class="font-medium"><?= e(implode(', ', (array)($quote->services ?? []))) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Budget:</span>
                        <span class="font-medium"><?= e($quote->budget) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Submitted:</span>
                        <span class="font-medium"><?= e($quote->created_at ?? '-') ?></span>
                    </div>
                </div>
            </div>
            <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this quote?')">Delete</button>
            </form>
            <a href="<?= url('admin/quotes') ?>" class="ml-4 text-blue-600 hover:underline">Back to Quotes</a>
        </div>
    <?php endif; ?>
</div>