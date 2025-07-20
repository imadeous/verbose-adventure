<div class="max-w-5xl mx-auto p-8 space-y-10">
    <!-- Top Section: 2 Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Card 1: Product Details -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-4">Product Details</h1>
            <div class="space-y-4 mb-6">
                <div class="flex items-center">
                    <span class="w-32 text-gray-500 font-semibold">Name:</span>
                    <span class="text-gray-900"><?= e($product->name) ?></span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-gray-500 font-semibold">Category:</span>
                    <span class="text-gray-900"><?= e($product->category) ?></span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-gray-500 font-semibold">Price:</span>
                    <span class="text-gray-900"><?= e($product->price) ?></span>
                </div>
                <div class="flex items-start">
                    <span class="w-32 text-gray-500 font-semibold">Description:</span>
                    <span class="text-gray-900"><?= e($product->description) ?></span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-6">
                <a href="<?= url('admin/products/edit/' . $product->id) ?>" class="btn btn-primary">Edit Product</a>
                <form action="<?= url('admin/products/delete/' . $product->id) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
        <!-- Card 2: Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 flex flex-col justify-between">
            <h2 class="text-xl font-bold text-gray-700 mb-6 border-b pb-4">Stats</h2>
            <div class="space-y-6">
                <div class="flex items-center">
                    <span class="w-40 text-gray-500 font-semibold">Total Revenue:</span>
                    <span class="text-green-700 font-bold text-lg">$12,340</span>
                </div>
                <div class="flex items-center">
                    <span class="w-40 text-gray-500 font-semibold">Total Orders:</span>
                    <span class="text-blue-700 font-bold text-lg">154</span>
                </div>
                <div class="flex items-center">
                    <span class="w-40 text-gray-500 font-semibold">Overall Rating:</span>
                    <span class="text-yellow-600 font-bold flex items-center text-lg">
                        4.7
                        <svg class="w-5 h-5 ml-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.049 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 3: Transactions Table -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Date</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Order ID</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Customer</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Amount</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border-b">2024-06-01</td>
                        <td class="px-4 py-2 border-b">#1001</td>
                        <td class="px-4 py-2 border-b">Alice Smith</td>
                        <td class="px-4 py-2 border-b">$120.00</td>
                        <td class="px-4 py-2 border-b"><span class="text-green-600 font-semibold">Completed</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b">2024-05-28</td>
                        <td class="px-4 py-2 border-b">#1000</td>
                        <td class="px-4 py-2 border-b">Bob Lee</td>
                        <td class="px-4 py-2 border-b">$80.00</td>
                        <td class="px-4 py-2 border-b"><span class="text-yellow-600 font-semibold">Pending</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b">2024-05-25</td>
                        <td class="px-4 py-2 border-b">#0999</td>
                        <td class="px-4 py-2 border-b">Carol King</td>
                        <td class="px-4 py-2 border-b">$150.00</td>
                        <td class="px-4 py-2 border-b"><span class="text-green-600 font-semibold">Completed</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border-b">2024-05-20</td>
                        <td class="px-4 py-2 border-b">#0998</td>
                        <td class="px-4 py-2 border-b">David Wu</td>
                        <td class="px-4 py-2 border-b">$60.00</td>
                        <td class="px-4 py-2 border-b"><span class="text-red-600 font-semibold">Failed</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>