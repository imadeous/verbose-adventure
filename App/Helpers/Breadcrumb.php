<?php

namespace App\Helpers;

/**
 * Breadcrumb helper for managing breadcrumb navigation.
 * Provides methods to add, retrieve, and render breadcrumbs.
 */

class Breadcrumb
{
    private static array $breadcrumbs = [];

    public static function add($labelOrCrumbs, ?string $url = null): void
    {
        if (is_array($labelOrCrumbs)) {
            foreach ($labelOrCrumbs as $crumb) {
                if (isset($crumb['label'])) {
                    self::$breadcrumbs[] = ['label' => $crumb['label'], 'url' => $crumb['url'] ?? null];
                }
            }
        } else {
            self::$breadcrumbs[] = ['label' => $labelOrCrumbs, 'url' => $url];
        }
    }

    public static function get(): array
    {
        return self::$breadcrumbs;
    }

    public static function clear(): void
    {
        self::$breadcrumbs = [];
    }

    public static function render(): void
    {
        echo '<nav class="flex border-b border-gray-200 bg-white" aria-label="Breadcrumb">';
        echo '<ol role="list" class="mx-auto flex w-full max-w-screen-xl space-x-4 px-4 sm:px-6 lg:px-8">';

        // Add a default Home breadcrumb
        echo '<li class="flex">';
        echo '  <div class="flex items-center">';
        echo '    <a href="' . url('admin') . '" class="text-gray-400 hover:text-gray-500">';
        echo '      <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" /></svg>';
        echo '      <span class="sr-only">Home</span>';
        echo '    </a>';
        echo '  </div>';
        echo '</li>';

        foreach (self::$breadcrumbs as $index => $breadcrumb) {
            echo '<li class="flex">';
            echo '  <div class="flex items-center">';
            echo '    <svg class="h-full w-6 shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true"><path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" /></svg>';

            $isLast = $index === count(self::$breadcrumbs) - 1;
            if ($breadcrumb['url'] && !$isLast) {
                echo '<a href="' . url($breadcrumb['url']) . '" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">' . \e($breadcrumb['label']) . '</a>';
            } else {
                echo '<span class="ml-4 text-sm font-medium text-gray-500"' . ($isLast ? ' aria-current="page"' : '') . '>' . e($breadcrumb['label']) . '</span>';
            }
            echo '  </div>';
            echo '</li>';
        }

        echo '</ol>';
        echo '</nav>';
    }
}
