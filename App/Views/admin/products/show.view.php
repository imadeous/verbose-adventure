<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8">
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
    <div class="flex justify-between items-center">
        <a href="<?= url('admin/products/edit/' . $product->id) ?>" class="btn btn-primary">Edit Product</a>
        <form action="<?= url('admin/products/delete/' . $product->id) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
            <button type="submit" class="btn btn-danger">Delete Product</button>
        </form>
    </div>
</div>