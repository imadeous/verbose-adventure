<?php

use App\Models\Category;
use App\Models\Product;
?>
<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-blue-900">Key Metrics (Last 30 Days)</h3>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Orders -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                <!-- icon unchanged -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Orders</div>
                <div class="text-2xl font-bold text-blue-900"><?= e($thisMonth['Total Orders'] ?? 0) ?></div>
            </div>
        </div>
        <!-- Revenue -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-300 text-blue-800 rounded-lg p-3 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-600 font-medium uppercase tracking-wide">Revenue</div>
                <div class="text-2xl font-bold text-blue-900"> <span class="text-xs text-blue-700">MVR </span><?= e(number_shorten($thisMonth['Total Amount'])) ?></div>
            </div>
        </div>
        <!-- Trend -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <?php
            $current = $thisMonth['Total Amount'] ?? 0;
            $previous = $lastMonth['Total Amount'] ?? 0;
            $percent = ($previous > 0) ? (($current - $previous) / $previous) * 100 : 0;
            $trendText = ($percent >= 0 ? '+' : '') . number_format($percent, 1) . '%';
            ?>
            <div class="bg-blue-200 <?= $percent >= 0 ? 'text-blue-600' : 'text-red-600' ?> rounded-lg p-3 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="<?= $percent <= 0 ? 'transform: scaleY(-1);' : '' ?>">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-400 font-medium uppercase tracking-wide">Trend</div>
                <div class="text-2xl font-bold text-blue-900"><?= $trendText ?></div>
            </div>
        </div>
        <!-- CSAT -->
        <div class="bg-blue-50 rounded-xl shadow-md p-5 flex items-center gap-4 border border-blue-200 hover:shadow-lg transition">
            <div class="bg-blue-300 text-blue-800 rounded-lg p-3 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">CSAT</div>
                <div class="text-2xl font-bold text-blue-900"><?php echo number_format($ratingStats['overallAvg'] ?? 0, 1); ?>/5</div>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    <h3 class="text-base font-semibold leading-6 text-blue-900">Business Insights</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        <!-- Revenue & Orders Chart -->
        <div class="col-span-1 lg:col-span-2 bg-blue-50 rounded-xl shadow-md p-5 flex flex-col border border-blue-200 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide">Revenue & Orders Trend</div>
            </div>
            <div class="flex-1 flex items-center justify-center" style="height:220px;min-height:180px;max-height:220px;">
                <canvas id="revenueOrdersChart" class="w-full max-w-xl" style="height:200px!important;max-height:200px;min-height:200px;" height="200"></canvas>
            </div>
        </div>
        <!-- Quarterly Report -->
        <div class="col-span-1 h-full bg-blue-50 rounded-xl shadow-md p-5 flex flex-col border border-blue-200 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-200 text-blue-700 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                </div>
                <div class="text-xs text-blue-500 font-medium uppercase tracking-wide"><?php echo date('Y') ?> Quarterly Report</div>
            </div>
            <div class="flex-1 flex flex-col items-center justify-center mt-2" style="height:180px;min-height:140px;max-height:180px;">
                <canvas id="quarterlyReportChart" class="w-full max-w-xs" style="height:140px!important;max-height:140px;min-height:140px;" height="140"></canvas>
                <ul class="text-blue-700 text-xs mt-4 w-full flex justify-between px-2">
                    <?php
                    foreach ($quarterlyChart->generate()[0] as $quarter): ?>
                        <li><?php echo $quarter['period_quarter']; ?>: <span class="font-semibold"><?php echo number_shorten($quarter['Total Amount']); ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 py-6">
        <!-- Top Categories -->
        <div class="col-span-1 bg-blue-50 rounded-xl shadow-md p-5 flex flex-col border border-blue-200 hover:shadow-lg transition">
            <h4 class="text-blue-700 font-semibold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                </svg>
                Hottest Categories
            </h4>
            <div class="flex flex-col gap-3">
                <?php foreach ($hottestCategories as $category): ?>
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="font-medium"><?php echo Category::find($category['category_id'])->name ?? 'Others'; ?></span>
                        <span class="ml-auto bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full"><?php echo $category['Count']; ?> orders</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Promo Code Usage -->
        <div class="col-span-1 bg-blue-50 rounded-xl shadow-md p-5 flex flex-col border border-blue-200 hover:shadow-lg transition">
            <h4 class="text-blue-600 font-semibold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                </svg>
                Promo Code Usage
            </h4>
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <span class="font-mono bg-blue-200 text-blue-800 px-2 py-1 rounded">WELCOME10</span>
                    <div class="w-32 bg-blue-100 rounded-full h-2 mx-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 70%"></div>
                    </div>
                    <span class="text-xs text-blue-700">6 uses</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-mono bg-blue-100 text-blue-700 px-2 py-1 rounded">SUMMER25</span>
                    <div class="w-32 bg-blue-50 rounded-full h-2 mx-2">
                        <div class="bg-blue-400 h-2 rounded-full" style="width: 35%"></div>
                    </div>
                    <span class="text-xs text-blue-700">3 uses</span>
                </div>
            </div>
        </div>
        <!-- Expense Breakdown -->
        <div class="col-span-1 bg-blue-50 rounded-xl shadow-md p-5 flex flex-col border border-blue-200 hover:shadow-lg transition">
            <h4 class="text-blue-800 font-semibold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
                </svg>
                Expense Breakdown
            </h4>
            <div class="flex flex-col gap-3">
                <?php foreach (($heaviestExpenses ?? []) as $category): ?>
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-700"></span>
                        <span class="font-medium"><?php echo Category::find($category['category_id'])->name ?? 'Others'; ?></span>
                        <span class="ml-auto font-semibold text-blue-900">MVR <?= e(number_shorten($category['Total'])) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-base font-semibold leading-6 text-blue-900">Rating Insights</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4 mb-8">
            <!-- Recent Reviews -->
            <div class="col-span-1 bg-blue-50 rounded-xl shadow-md p-5 border border-blue-200 hover:shadow-lg transition flex flex-col overflow-y-scroll max-h-[500px]">
                <h4 class="text-blue-700 font-semibold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                    Recent Reviews
                </h4>
                <div class="flex flex-col gap-3">
                    <?php foreach (($recentReviews ?? []) as $review): ?>
                        <div class="bg-blue-100 border border-blue-200 rounded-lg p-4 flex flex-col gap-2 shadow-sm">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-semibold text-blue-900"><?= e($review->customer_name) ?></span>
                                <span class="flex space-x-2">
                                    <span class="text-xs text-blue-400 ml-auto flex space-x-2"><?= e($review->recommendation_score ?? '-') ?></span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-4 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <?php $stars = round($review->quality_rating ?? 0);
                                for ($i = 1; $i <= 5; $i++): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 <?= $i <= $stars ? 'text-blue-700' : 'text-blue-300' ?>">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <div class="text-blue-700 text-sm"><?= e($review->comments) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Recommendations + Overall Ratings (Stacked) -->
            <div class="col-span-1 flex flex-col gap-6 h-full">
                <!-- Recommendations (1x1) -->
                <div class="bg-blue-50 rounded-xl shadow-md p-5 border border-blue-200 hover:shadow-lg transition flex flex-col items-start justify-center">
                    <div class="flex flex-col w-full">
                        <h4 class="text-blue-500 font-semibold mb-4 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                            </svg>
                            Recommendations
                        </h4>
                        <div
                            class="flex items-center gap-2 w-full justify-between">
                            <div class="flex flex-col flex-1 items-start w-full">
                                <div class="text-3xl font-bold text-blue-900 mb-2"><?= number_format($ratingStats['recommendPercent'], 0) ?? 0 ?>%</div>
                                <div class="text-sm text-blue-400">Based on <?= $ratingStats['count'] ?? 0 ?> reviews</div>
                            </div>
                            <div class="flex-shrink-0 flex items-center justify-end">
                                <?php if ($ratingStats['recommendPercent'] > 50): ?>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-12 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>
                                <?php else: ?>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-12 text-blue-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Overall Ratings (1x2) -->
                <div class="flex-1 bg-blue-50 rounded-xl shadow-md p-5 border border-blue-200 hover:shadow-lg transition flex flex-col items-start">
                    <h4 class="text-blue-700 font-bold mb-4 flex gap-2 items-center text-base tracking-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        Overall Ratings
                    </h4>
                    <div class="flex flex-col items-start w-full">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-3xl font-extrabold text-blue-900"><?= number_format($ratingStats['overallAvg'] ?? 0, 1) ?></span>
                            <div class="flex">
                                <?php $stars = round($ratingStats['overallAvg'] ?? 0);
                                for ($i = 1; $i <= 5; $i++): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 <?= $i <= $stars ? 'text-blue-700' : 'text-blue-300' ?>">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="text-xs text-blue-400 mb-4">Based on <?= $ratingStats['count'] ?? 0 ?> reviews</div>
                        <div class="w-full">
                            <div class="grid grid-cols-1 gap-2">
                                <?php foreach (($ratingStats['ratings'] ?? []) as $matrix => $score): ?>
                                    <?php
                                    $percent = ($score / 5) * 100;
                                    ?>
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-blue-400"></span>
                                        <span class="flex-1 text-sm text-blue-900 font-medium"><?= e($matrix) ?></span>
                                        <div class="w-24 bg-blue-200 rounded-full h-2 mx-2">
                                            <div class="bg-blue-400 h-2 rounded-full" style="width: <?= $percent ?>%"></div>
                                        </div>
                                        <span class="text-xs text-blue-700 font-semibold"><?= number_format($score, 1) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top Rated Products -->
            <div class="col-span-1 bg-blue-50 rounded-xl shadow-md p-5 border border-blue-200 hover:shadow-lg transition flex flex-col">
                <h4 class="text-blue-500 font-semibold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                    Top Rated Products
                </h4>
                <div class="flex flex-col gap-3">
                    <?php foreach ($topRatedProducts as $product): ?>
                        <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 transition border border-transparent hover:border-blue-300 shadow-sm">
                            <span class="inline-block w-3 h-3 rounded-full text-blue-700"></span>
                            <span class="font-medium text-blue-900 flex-1"><?php echo Product::find($product['product_id'])->name ?? 'Unknown Product'; ?></span>
                            <div class="flex items-center gap-1 bg-blue-200 px-2 py-1 rounded-full">
                                <span class="text-blue-700 font-bold"><?php echo number_format($product['Overall Rating'], 1); ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-700">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Transactions Chart (dynamic from PHP)
    const ctx1 = document.getElementById('revenueOrdersChart').getContext('2d');
    const transactionsChartConfig = <?php echo $transactionsChart; ?>;
    new Chart(ctx1, transactionsChartConfig);

    // Quarterly Report Bar Chart
    const ctx2 = document.getElementById('quarterlyReportChart').getContext('2d');
    const quarterlyReportChartConfig = JSON.parse(`<?php echo addslashes($quarterlyChart->toJson()); ?>`);
    new Chart(ctx2, quarterlyReportChartConfig);
</script>