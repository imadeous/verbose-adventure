<div class="max-w-xl mx-auto" x-data="incomeForm()">
    <h1 class="text-2xl font-bold text-blue-900 mb-6">Add Income</h1>
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
    <form action="<?= url('admin/transactions/income') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <input type="hidden" name="type" value="income">

        <div>
            <label class="block text-blue-700 font-semibold mb-1">SKU (optional)</label>
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
                    <div><span class="font-semibold">Price:</span> MVR <span x-text="variantInfo?.price"></span></div>
                    <div><span class="font-semibold">Stock Available:</span> <span x-text="variantInfo?.stock_quantity"></span></div>
                    <div x-show="variantInfo?.dimensions"><span class="font-semibold">Dimensions:</span> <span x-text="variantInfo?.dimensions"></span></div>
                    <div x-show="variantInfo?.color"><span class="font-semibold">Color:</span> <span x-text="variantInfo?.color"></span></div>
                </div>
            </div>

            <div x-show="skuError" x-cloak class="mt-2 text-red-600 text-sm" x-text="skuError"></div>

            <!-- Hidden fields for product_id, variant_id, category_id (auto-resolved from SKU) -->
            <input type="hidden" name="product_id" x-model="productId">
            <input type="hidden" name="variant_id" x-model="variantId">
            <input type="hidden" name="category_id" x-model="categoryId">
        </div>

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
                Subtotal: MVR <span x-text="(quantity * (variantInfo?.price || 0)).toFixed(2)"></span>
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
            <label class="block text-blue-700 font-semibold mb-1">Customer Username (optional)</label>
            <input type="text" name="customer_username" class="w-full border border-blue-300 rounded-lg px-3 py-2" placeholder="Enter customer username or identifier">
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Platform (optional)</label>
            <select name="platform" class="w-full border border-blue-300 rounded-lg px-3 py-2">
                <option value="">Select Platform</option>
                <option value="instagram">Instagram</option>
                <option value="tiktok">Tiktok</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="facebook">Facebook</option>
                <option value="website">Website</option>
                <option value="phone">Phone</option>
                <option value="in-person">In Person</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div>
            <label class="block text-blue-700 font-semibold mb-1">Date</label>
            <input type="date" name="date" class="w-full border border-blue-300 rounded-lg px-3 py-2" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="flex justify-end gap-3">
            <a href="<?= url('/admin/transactions') ?>" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold shadow border border-gray-300 hover:bg-gray-300">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow border border-blue-700 hover:bg-blue-700">Add Income</button>
        </div>
    </form>
</div>
<script>
    function incomeForm() {
        return {
            sku: '',
            variantInfo: null,
            skuError: '',
            productId: '',
            variantId: '',
            categoryId: '',
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