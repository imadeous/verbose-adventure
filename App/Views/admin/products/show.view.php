<div class="max-w-5xl mx-auto p-8 space-y-10">
    <!-- Top Section: 2 Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1: Product Details -->
        <div class="col-span-2 bg-blue-50 rounded-xl shadow-md flex flex-col gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="flex items-center gap-4 mb-2">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Product icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M6.364 6.364l-1.591 1.591M3 12h2.25m1.114 5.636-1.591 1.591m5.636 1.114V21m5.636-1.114 1.591 1.591m1.114-5.636H21m-1.114-5.636 1.591-1.591M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-blue-900">Product Details</h1>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Name</span>
                    <span class="text-lg font-bold text-blue-900"><?= e($product->name) ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Category</span>
                    <span class="text-blue-900"><?= e($product->category) ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Price</span>
                    <span class="text-blue-900"><?= e($product->price) ?></span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-xs text-blue-500 font-medium uppercase tracking-wide w-28">Description</span>
                    <span class="text-blue-800"><?= e($product->description) ?></span>
                </div>
            </div>
            <div class="flex gap-3 mt-2 justify-end items-center">
                <a href="<?= url('admin/products/' . $product->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 rounded px-3 py-1 font-semibold transition shadow-sm">View</a>
                <a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border border-yellow-300 rounded px-3 py-1 font-semibold transition shadow-sm">Edit</a>
                <form action="<?= url('admin/products/' . $product->id . '/delete') ?>" method="POST" style="display:inline;">
                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-3 py-1 font-semibold transition shadow-sm" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </div>
        </div>
        <!-- Card 2: Stats (Stacked) -->
        <div class="flex flex-col gap-5">
            <!-- Orders Card -->
            <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Orders icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Orders</div>
                    <div class="text-2xl font-bold text-blue-900">154</div>
                </div>
            </div>
            <!-- Revenue Card -->
            <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Revenue icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4-1.343 4-3-1.79-3-4-3Zm0 0V6m0 8v2m-6 2a9 9 0 1 1 18 0 9 9 0 0 1-18 0Z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Revenue</div>
                    <div class="text-2xl font-bold text-blue-900">$12,340</div>
                </div>
            </div>
            <!-- Rating Card -->
            <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <!-- Star icon -->
                    <svg class="size-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.049 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Rating</div>
                    <div class="text-2xl font-bold text-blue-900 flex items-center gap-1">4.7 <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.049 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z" />
                        </svg></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 3: Transactions Table -->
    <div class="bg-white rounded-xl shadow-md border border-blue-100 overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">productname & Email</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-blue-400">No transactions found for this product.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="font-semibold text-blue-900"><?= e($transaction->customer_name) ?></div>
                                <div class="text-blue-500 text-xs"><?= e($transaction->customer_email) ?></div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-blue-700"><?= e($transaction->role ?? 'Customer') ?></td>
                            <td class="px-4 py-2 whitespace-nowrap flex items-center space-x-2">
                                <a href="<?= url('admin/transactions/' . $transaction->id) ?>" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-300 rounded px-2 py-1 flex items-center gap-1 transition shadow-sm" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9m7.5 0v10.5A2.25 2.25 0 0 1 13.5 21h-3A2.25 2.25 0 0 1 8.25 19.5V9m7.5 0H8.25m7.5 0a2.25 2.25 0 0 1 2.25 2.25v7.5A2.25 2.25 0 0 1 15.75 21H8.25A2.25 2.25 0 0 1 6 19.5v-7.5A2.25 2.25 0 0 1 8.25 9h7.5z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>