<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Quote Details</h1>
    <?php if (!$quote): ?>
        <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-4">Quote not found.</div>
    <?php else: ?>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <span class="font-semibold text-gray-700">Name:</span> <?= e($quote->name) ?><br>
                <span class="font-semibold text-gray-700">Email:</span> <?= e($quote->email) ?><br>
                <span class="font-semibold text-gray-700">Phone:</span> <?= e($quote->phone) ?><br>
                <span class="font-semibold text-gray-700">Instagram:</span> <?= e($quote->instagram) ?><br>
                <span class="font-semibold text-gray-700">Delivery Address:</span> <?= e($quote->delivery_address) ?><br>
                <span class="font-semibold text-gray-700">Billing Address:</span> <?= e($quote->billing_address) ?><br>
                <span class="font-semibold text-gray-700">Product Type:</span> <?= e($quote->product_type) ?><br>
                <span class="font-semibold text-gray-700">Material:</span> <?= e($quote->material) ?><br>
                <span class="font-semibold text-gray-700">Quantity:</span> <?= e($quote->quantity) ?><br>
                <span class="font-semibold text-gray-700">Timeline:</span> <?= e($quote->timeline) ?><br>
                <span class="font-semibold text-gray-700">Description:</span> <?= e($quote->description) ?><br>
                <span class="font-semibold text-gray-700">Budget:</span> <?= e($quote->budget) ?><br>
                <span class="font-semibold text-gray-700">Services:</span> <?= e(implode(', ', (array)($quote->services ?? []))) ?><br>
                <span class="font-semibold text-gray-700">Submitted:</span> <?= e($quote->created_at ?? '-') ?><br>
            </div>
            <form action="<?= url('admin/quotes/' . $quote->id . '/delete') ?>" method="POST" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this quote?')">Delete</button>
            </form>
            <a href="<?= url('admin/quotes') ?>" class="ml-4 text-blue-600 hover:underline">Back to Quotes</a>
        </div>
    <?php endif; ?>
</div>