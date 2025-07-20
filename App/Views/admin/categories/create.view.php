<?php $this->section('content'); ?>
<h1 class="text-2xl font-bold mb-4">Add Category</h1>
<form action="<?= url('admin/categories') ?>" method="POST">
    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" class="input" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= url('admin/categories') ?>" class="btn">Cancel</a>
</form>
<?php $this->endSection(); ?>