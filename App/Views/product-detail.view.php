<!-- Product Detail Section -->
<section class="text-gray-400 bg-gray-900 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <!-- Image Gallery -->
            <div class="lg:w-1/2 w-full" x-data="{ 
                currentImage: 0,
                images: <?php

                        use App\Models\Product;

                        $images = Product::getImages($product->id);
                        echo json_encode(array_map(function ($img) {
                            return $img['image_url'];
                        }, $images));
                        ?>
            }">
                <!-- Main Image -->
                <div class="relative h-96 rounded-lg overflow-hidden mb-4">
                    <?php if (!empty($images)): ?>
                        <template x-for="(image, index) in images" :key="index">
                            <img
                                x-show="currentImage === index"
                                :alt="'<?= htmlspecialchars($product->name ?? 'Product') ?> - Image ' + (index + 1)"
                                class="w-full h-full object-cover object-center"
                                :src="image">
                        </template>
                    <?php else: ?>
                        <img alt="<?= htmlspecialchars($product->name ?? 'Product') ?>"
                            class="w-full h-full object-cover object-center"
                            src="https://dummyimage.com/600x400/1f2937/9ca3af?text=No+Image">
                    <?php endif; ?>
                </div>

                <!-- Thumbnail Navigation -->
                <?php if (count($images) > 1): ?>
                    <div class="flex gap-2 overflow-x-auto">
                        <template x-for="(image, index) in images" :key="index">
                            <button
                                @click="currentImage = index"
                                :class="currentImage === index ? 'ring-2 ring-indigo-500' : ''"
                                class="flex-shrink-0 w-20 h-20 rounded overflow-hidden focus:outline-none">
                                <img :src="image"
                                    :alt="'Thumbnail ' + (index + 1)"
                                    class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Information -->
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest mb-1">
                    <?= htmlspecialchars($product->category_id ?? 'General') ?>
                </h2>
                <h1 class="text-white text-3xl title-font font-medium mb-4">
                    <?= htmlspecialchars($product->name ?? 'Product Name') ?>
                </h1>
                <p class="leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($product->description ?? 'No description available.')) ?>
                </p>
            </div>
        </div>
    </div>
</section>