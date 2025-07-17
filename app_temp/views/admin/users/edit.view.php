<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>
    <form action="<?= url('/admin/users/' . $user->id) ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div>
            <label>Username</label>
            <input type="text" name="username" class="input w-full" value="<?= e($user->username) ?>" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" class="input w-full" value="<?= e($user->email) ?>" required>
        </div>
        <div>
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="input w-full">
        </div>
        <div>
            <label>Role</label>
            <select name="role" class="input w-full">
                <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>