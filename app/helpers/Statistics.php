<?php
// helpers/Statistics.php

namespace Helpers;

class Statistics
{
    /**
     * Calculate the average (mean) of an array of numbers.
     */
    public static function mean(array $values): float
    {
        if (empty($values)) return 0.0;
        return array_sum($values) / count($values);
    }

    /**
     * Calculate the median of an array of numbers.
     */
    public static function median(array $values): float
    {
        if (empty($values)) return 0.0;
        sort($values);
        $count = count($values);
        $middle = (int)($count / 2);
        if ($count % 2) {
            return (float)$values[$middle];
        }
        return ($values[$middle - 1] + $values[$middle]) / 2.0;
    }

    /**
     * Calculate the mode(s) of an array of numbers.
     * Returns an array of the most frequent value(s).
     */
    public static function mode(array $values): array
    {
        if (empty($values)) return [];
        $counts = array_count_values($values);
        $max = max($counts);
        return array_keys($counts, $max, true);
    }

    /**
     * Calculate the standard deviation of an array of numbers.
     */
    public static function stddev(array $values): float
    {
        $n = count($values);
        if ($n === 0) return 0.0;
        $mean = self::mean($values);
        $sum = 0.0;
        foreach ($values as $v) {
            $sum += pow($v - $mean, 2);
        }
        return sqrt($sum / $n);
    }

    /**
     * Calculate the minimum value in an array.
     */
    public static function min(array $values)
    {
        return empty($values) ? null : min($values);
    }

    /**
     * Calculate the maximum value in an array.
     */
    public static function max(array $values)
    {
        return empty($values) ? null : max($values);
    }

    /**
     * Calculate the sum of an array of numbers.
     */
    public static function sum(array $values)
    {
        return array_sum($values);
    }
}
