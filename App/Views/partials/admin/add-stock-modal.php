<!-- Add Stock Modal -->
<div x-show="showStockModal"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true">

    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="closeStockModal()"></div>

    <!-- Modal panel -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all w-full max-w-lg"
            @click.away="closeStockModal()">

            <!-- Modal Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                        Add Stock
                    </h3>
                    <button type="button"
                        @click="closeStockModal()"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form method="POST" :action="`/admin/variants/${selectedVariant.id}/add-stock`">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product->id ?>">

                <div class="bg-white px-6 py-5 space-y-6">
                    <!-- Variant Info -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">SKU:</span>
                                <span class="text-sm font-semibold text-gray-900" x-text="selectedVariant.sku"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Current Stock:</span>
                                <span class="text-sm font-semibold"
                                    :class="selectedVariant.currentStock > 0 ? 'text-green-600' : 'text-red-600'"
                                    x-text="selectedVariant.currentStock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Quantity Input -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Quantity to Add <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            id="stock_quantity"
                            name="stock_quantity"
                            x-model.number="stockQuantity"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter quantity to add">
                        <p class="mt-2 text-sm text-gray-500">
                            New stock will be: <span class="font-semibold text-gray-900" x-text="selectedVariant.currentStock + stockQuantity"></span>
                        </p>
                    </div>

                    <!-- Notes (Optional) -->
                    <div class="hidden">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (Optional)
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Add any notes about this stock addition..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-200">
                    <button type="button"
                        @click="closeStockModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit"
                        :disabled="stockQuantity <= 0"
                        :class="stockQuantity <= 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-700'"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Add Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>