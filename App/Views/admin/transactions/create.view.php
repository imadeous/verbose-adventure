<div class="max-w-xl mx-auto" x-data="transactionForm()">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Add Transaction</h1>
    <?php if (!empty($breadcrumb)): ?>
        <nav class="mb-4 text-xs text-blue-600">
            <?php foreach ($breadcrumb as $i => $item): ?>
                <?php if (!empty($item['url'])): ?>
                    <a href="<?= $item['url'] ?>" class="hover:underline"><?= htmlspecialchars($item['label']) ?></a>
                <?php else: ?>
                    <span><?= htmlspecialchars($item['label']) ?></span>
                <?php endif; ?>
                <?php if ($i < count($breadcrumb) - 1): ?> &raquo; <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
    <form action="<?= url('admin/transactions') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Type</label>
            <select name="type" x-model="transactionType" class="w-full border border-blue-300 rounded-lg px-3 py-2" required>
                <option value="">Select Type</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>
        <div x-show="transactionType === 'income'">
            <label class="block text-blue-700 font-semibold mb-1">SKU (optional for Income)</label>
            <input type="text"
                x-model="sku"
                @input.debounce.500ms="lookupSKU()"
                class="w-full border border-blue-300 rounded-lg px-3 py-2"
                placeholder="Enter product SKU">

            <!-- Variant info display -->
            <div x-show="variantInfo" x-cloak class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="text-sm space-y-1">
                    <div><span class="font-semibold">Product:</span> <span x-text="variantInfo?.product_name"></span></div>
                    <div><span class="font-semibold">Category:</span> <span x-text="variantInfo?.category_name"></span></div>
                    <div><span class="font-semibold">Price:</span> $<span x-text="variantInfo?.price"></span></div>
                    <div><span class="font-semibold">Stock Available:</span> <span x-text="variantInfo?.stock_quantity"></span></div>
                    <div x-show="variantInfo?.dimensions"><span class="font-semibold">Dimensions:</span> <span x-text="variantInfo?.dimensions"></span></div>
                    <div x-show="variantInfo?.color"><span class="font-semibold">Color:</span> <span x-text="variantInfo?.color"></span></div>
                </div>
            </div>

            <div x-show="skuError" x-cloak class="mt-2 text-red-600 text-sm" x-text="skuError"></div>

            <!-- Hidden fields for product_id, variant_id -->
            <input type="hidden" name="product_id" x-model="productId">
            <input type="hidden" name="variant_id" x-model="variantId">
        </div>

        <!-- Category field: Hidden when variant is auto-filled (income with SKU), visible dropdown otherwise -->
        <div x-show="!variantInfo || transactionType === 'expense'" x-cloak>
            <label class="block text-blue-700 font-semibold mb-1">Category (optional)</label>
            <select name="category_id" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                <option value="">Select Category</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category->id) ?>">
                            <?= htmlspecialchars($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Hidden category field when variant info is present (income with SKU) -->
        <input type="hidden" name="category_id" x-model="categoryId" x-show="variantInfo && transactionType === 'income'">

        <div x-show="variantInfo" x-cloak>
            <label class="block text-blue-700 font-semibold mb-1">Quantity</label>
            <input type="number"
                name="quantity"
                x-model.number="quantity"
                @input="calculateAmount()"
                min="1"
                :max="variantInfo?.stock_quantity || 999"
                class="w-full border border-blue-300 rounded-lg px-3 py-2"
                placeholder="Enter quantity">
            <p class="mt-1 text-sm text-gray-600" x-show="quantity > 0">
                Subtotal: $<span x-text="(quantity * (variantInfo?.price || 0)).toFixed(2)"></span>
            </p>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Amount</label>
            <input type="number"
                name="amount"
                x-model="amount"
                step="0.01"
                class="w-full border border-blue-300 rounded-lg px-3 py-2"
                :readonly="variantInfo !== null"
                required>
            <p class="mt-1 text-xs text-gray-500" x-show="variantInfo">
                Amount is auto-calculated from quantity × price
            </p>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Description (optional)</label>
            <input type="text" name="description" class="w-full border border-blue-300 rounded-lg px-3 py-2">
        </div>
        <?php if (!empty($quotes)): ?>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Quote (optional)</label>
                <select name="quote_id" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                    <option value="">Select Quote</option>
                    <?php foreach ($quotes as $quote): ?>
                        <option value="<?= htmlspecialchars($quote->id) ?>">
                            <?= htmlspecialchars($quote->reference ?? $quote->id) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <?php if (!empty($promo_codes)): ?>
            <div>
                <label class="block text-blue-700 font-semibold mb-1">Promo Code (optional)</label>
                <select name="promo_code_id" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                    <option value="">Select Promo Code</option>
                    <?php foreach ($promo_codes as $promo): ?>
                        <option value="<?= htmlspecialchars($promo['id']) ?>">
                            <?= htmlspecialchars($promo['code'] ?? $promo['id']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Date</label>
            <input type="date" name="date" class="w-full border border-blue-300 rounded-lg px-3 py-2" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700">Add Transaction</button>
        </div>
    </form>
</div>
<script>
    function transactionForm() {
        return {
            transactionType: '',
            sku: '',
            variantInfo: null,
            skuError: '',
            productId: '',
            variantId: '',
            categoryId: '',
            manualCategoryId: '',
            quantity: 0,
            amount: 0,

            calculateAmount() {
                if (this.variantInfo && this.quantity > 0) {
                    this.amount = (this.quantity * parseFloat(this.variantInfo.price || 0)).toFixed(2);
                } else {
                    this.amount = 0;
                }
            },

            async lookupSKU() {
                if (!this.sku || this.sku.trim() === '') {
                    this.variantInfo = null;
                    this.skuError = '';
                    this.clearIds();
                    return;
                }

                try {
                    const response = await fetch(`/admin/variants/lookup-sku?sku=${encodeURIComponent(this.sku)}`);
                    const data = await response.json();

                    if (data.success && data.variant) {
                        this.variantInfo = data.variant;
                        this.productId = data.variant.product_id;
                        this.variantId = data.variant.id;
                        this.categoryId = data.variant.category_id || '';
                        this.quantity = 1;
                        this.calculateAmount();
                        this.skuError = '';
                    } else {
                        this.variantInfo = null;
                        this.skuError = data.message || 'SKU not found';
                        this.clearIds();
                    }
                } catch (error) {
                    console.error('SKU lookup error:', error);
                    this.skuError = 'Error looking up SKU';
                    this.variantInfo = null;
                    this.clearIds();
                }
            },

            clearIds() {
                this.productId = '';
                this.variantId = '';
                this.categoryId = '';
                this.quantity = 0;
                this.amount = 0;
            }
        }
    }
</script>