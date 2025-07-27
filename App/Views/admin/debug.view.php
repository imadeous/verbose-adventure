<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Debug Panel</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet"> -->
</head>

<body class="bg-zinc-900 text-zinc-100 font-mono">
    <div class="max-w-3xl mx-auto mt-12 bg-zinc-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-sky-400">Debug Panel</h1>
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-yellow-400">Variables Dump</h2>
            <pre class="bg-zinc-900 text-yellow-300 p-4 rounded-md overflow-x-auto text-base">
<?php if (isset($vars)) var_dump($vars);
else echo 'No debug variables set.'; ?>
            </pre>
        </div>
    </div>
</body>

</html>