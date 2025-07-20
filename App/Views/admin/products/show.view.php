<h1 class="text-2xl font-bold mb-4">Product Details</h1>
<div class="mb-4">
    <strong>Name:</strong> <?= e($product->name) ?><br>
    <strong>Category:</strong> <?= e($product->category) ?><br>
    <strong>Price:</strong> <?= e($product->price) ?><br>
    <strong>Description:</strong> <?= e($product->description) ?><br>
</div>
<a href="<?= url('admin/products/' . $product->id . '/edit') ?>" class="btn btn-primary">Edit</a>
<a href="<?= url('admin/products') ?>" class="btn">Back to List</a>