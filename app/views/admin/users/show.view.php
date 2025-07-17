<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">User Details</h1>
    <div class="mb-2"><strong>ID:</strong> <?= e($user->id) ?></div>
    <div class="mb-2"><strong>Username:</strong> <?= e($user->username) ?></div>
    <div class="mb-2"><strong>Email:</strong> <?= e($user->email) ?></div>
    <div class="mb-2"><strong>Role:</strong> <?= e($user->role) ?></div>
    <a href="<?= url('/admin/users/' . $user->id . '/edit') ?>" class="btn btn-secondary mt-4">Edit</a>
    <a href="<?= url('/admin/users') ?>" class="btn btn-light mt-4">Back to List</a>
</div>