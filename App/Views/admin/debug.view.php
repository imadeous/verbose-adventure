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
<?php
var_dump($vars);
?>
            </pre>
        </div>

    </div>

</div>
<canvas id="quarterlyReportChart" class="w-full h-96"></canvas>
<script>
    // Quarterly Report Bar Chart
    const ctx2 = document.getElementById('quarterlyReportChart').getContext('2d');
    const quarterlyReportChartConfig = JSON.parse(`<?php echo addslashes($vars['products']); ?>`);
    new Chart(ctx2, quarterlyReportChartConfig);
</script>