<div class="bg-zinc-900 text-zinc-100 font-mono">
    <div class="max-w-full mx-auto bg-zinc-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-sky-400">Debug Panel</h1>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-yellow-400">SQL Query</h2>
            <pre class="bg-zinc-900 text-yellow-300 p-4 rounded-md whitespace-pre-wrap break-words text-base">
<?php if (isset($query)) echo $query;
else echo 'No SQL query set.'; ?>
            </pre>
        </div>
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-yellow-400">Variables Dump</h2>
            <pre class="bg-zinc-900 text-yellow-300 p-4 rounded-md whitespace-pre-wrap break-words text-base">
<?php if (isset($vars)) var_dump($vars);
else echo 'No debug variables set.'; ?>
            </pre>
        </div>
        <div>
            make a table to display the hottest categories
            <h2 class="text-xl font-semibold mb-4 text-yellow-400">Hottest Categories</h2>
            <?php if (isset($hottestCategories) && !empty($hottestCategories)): ?>
                <table class="min-w-full bg-zinc-800 text-sm">
                    <thead>
                        <tr class="border-b border-zinc-700">
                            <th class="px-4 py-2 text-left text-yellow-300">Category</th>
                            <th class="px-4 py-2 text-left text-yellow-300">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hottestCategories as $category): ?>
                            <tr class="border-b border-zinc-700">
                                <td class="px-4 py-2"><?= htmlspecialchars($category['description']) ?></td>
                                <td class="px-4 py-2"><?= number_format($category['Total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-yellow-300">No hottest categories data available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>