<?php
// Usage: include this partial in your layout or view
// Pass $breadcrumb = [['label' => 'Dashboard', 'url' => url('admin')], ...]
if (!isset($breadcrumb) || !is_array($breadcrumb) || empty($breadcrumb)) return;
?>
<section class="bg-gray-200">
    <nav class="flex border-b border-gray-200 bg-white" aria-label="Breadcrumb">
        <ol role="list" class="mx-auto flex w-full max-w-screen-xl space-x-4 px-4 sm:px-6 lg:px-8">
            <?php foreach ($breadcrumb as $i => $item): ?>
                <li class="flex">
                    <div class="flex items-center">
                        <?php if ($i === 0): ?>
                            <a href="<?= e($item['url']) ?>" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        <?php else: ?>
                            <svg class="h-full w-6 shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
                                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                            </svg>
                            <?php if ($i < count($breadcrumb) - 1): ?>
                                <a href="<?= e($item['url']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    <?= e($item['label']) ?>
                                </a>
                            <?php else: ?>
                                <span class="ml-4 text-sm font-medium text-gray-700" aria-current="page">
                                    <?= e($item['label']) ?>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
</section>