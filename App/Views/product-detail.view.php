<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Placeholder for image gallery (will add next) -->
            <div class="lg:w-1/2 w-full">
                <div class="relative h-96 rounded-lg overflow-hidden mb-4 bg-gray-800 flex items-center justify-center">
                    <span class="text-gray-500">Image will be added in next step</span>
                </div>
            </div>

            <!-- Product Information -->
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest mb-1">
                    <?= htmlspecialchars($product['category_id'] ?? 'General') ?>
                </h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product['name'] ?? 'Product Name') ?>
                </h1>
                <p class="leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'No description available.')) ?>
                </p>
            </div>
        </div>
    </div>
</section>