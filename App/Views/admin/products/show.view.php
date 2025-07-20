<div class="max-w-5xl mx-auto p-8 space-y-10">
    <!-- Top Section: 2 Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Card 1: Product Details -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
            <h1 class="text-3xl font-extrabold text-blue-900 mb-6 border-b border-blue-100 pb-4">Product Details</h1>
            <div class="space-y-4 mb-6">
                <div class="flex items-center">
                    <span class="w-32 text-blue-700 font-semibold">Name:</span>
                    <span class="text-blue-900 font-bold"><?= e($product->name) ?></span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-blue-700 font-semibold">Category:</span>
                    <span class="text-blue-900"><?= e($product->category) ?></span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-blue-700 font-semibold">Price:</span>
                    <span class="text-blue-900"><?= e($product->price) ?></span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 text-blue-700 font-semibold">Description:</span>
                    <span class="text-blue-800"><?= e($product->description) ?></span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-6">
                <a href="<?= url('admin/products/edit/' . $product->id) ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 transition">Edit Product</a>
                <form action="<?= url('admin/products/delete/' . $product->id) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 border border-red-200 rounded px-5 py-2 font-semibold shadow transition">Delete Product</button>
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
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100">
        <h2 class="text-2xl font-bold text-blue-900 mb-6 border-b border-blue-100 pb-4">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg text-sm">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Order ID</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Customer</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-bold text-blue-800 uppercase tracking-wide border-b-2 border-blue-200">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border-b border-blue-100">2024-06-01</td>
                        <td class="px-4 py-2 border-b border-blue-100">#1001</td>
                        <td class="px-4 py-2 border-b border-blue-100">Alice Smith</td>
                        <td class="px-4 py-2 border-b border-blue-100">$120.00</td>
                        <td class="px-4 py-2 border-b border-blue-100"><span class="text-green-700 font-semibold">Completed</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b border-blue-100">2024-05-28</td>
                        <td class="px-4 py-2 border-b border-blue-100">#1000</td>
                        <td class="px-4 py-2 border-b border-blue-100">Bob Lee</td>
                        <td class="px-4 py-2 border-b border-blue-100">$80.00</td>
                        <td class="px-4 py-2 border-b border-blue-100"><span class="text-yellow-600 font-semibold">Pending</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b border-blue-100">2024-05-25</td>
                        <td class="px-4 py-2 border-b border-blue-100">#0999</td>
                        <td class="px-4 py-2 border-b border-blue-100">Carol King</td>
                        <td class="px-4 py-2 border-b border-blue-100">$150.00</td>
                        <td class="px-4 py-2 border-b border-blue-100"><span class="text-green-700 font-semibold">Completed</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b border-blue-100">2024-05-20</td>
                        <td class="px-4 py-2 border-b border-blue-100">#0998</td>
                        <td class="px-4 py-2 border-b border-blue-100">David Wu</td>
                        <td class="px-4 py-2 border-b border-blue-100">$60.00</td>
                        <td class="px-4 py-2 border-b border-blue-100"><span class="text-red-600 font-semibold">Failed</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>