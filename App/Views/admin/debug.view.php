<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Debug Panel</title>
    <style>
        body {
            background: #18181b;
            color: #e5e7eb;
            font-family: 'Fira Mono', 'Consolas', monospace;
            margin: 0;
            padding: 0;
        }

        .debug-container {
            max-width: 900px;
            margin: 40px auto;
            background: #232336;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0002;
            padding: 32px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #38bdf8;
        }

        pre {
            background: #18181b;
            color: #facc15;
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 1rem;
        }

        .debug-vars {
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="debug-container">
        <h1>Debug Panel</h1>
        <div class="debug-vars">
            <h2>Variables Dump</h2>
            <pre><?php if (isset($vars)) var_dump($vars);
                    else echo 'No debug variables set.'; ?></pre>
        </div>
    </div>
</body>

</html>