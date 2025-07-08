<?php
// helpers/Report.php
// Helper for generating grouped reports with totals and averages for any table/column/date range

namespace Helpers;

use Core\App;
use PDO;

class Report
{
    /**
     * Generate a grouped report for a table.
     *
     * @param string $table Target table name
     * @param string $period One of: hourly, daily, weekly, monthly, yearly
     * @param string|null $startDate Start date (Y-m-d or Y-m-d H:i:s), optional
     * @param string|null $endDate End date (Y-m-d or Y-m-d H:i:s), optional
     * @param string $dateColumn Date column to group by (default: created_at)
     * @param string $dataColumn Data column to aggregate (default: amount)
     * @return array JSON-serializable array with grouped data, totals, and average
     */
    public static function generate(
        string $table,
        string $period = 'daily',
        ?string $startDate = null,
        ?string $endDate = null,
        string $dateColumn = 'created_at',
        string $dataColumn = 'amount'
    ): array {
        $pdo = App::get('database')->getPdo();
        $periodFormat = [
            'hourly' => '%Y-%m-%d %H:00:00',
            'daily' => '%Y-%m-%d',
            'weekly' => '%x-W%v', // ISO week
            'monthly' => '%Y-%m',
            'yearly' => '%Y',
        ];
        $format = $periodFormat[$period] ?? $periodFormat['daily'];
        $params = [];
        $where = [];
        if ($startDate) {
            $where[] = "$dateColumn >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $where[] = "$dateColumn <= ?";
            $params[] = $endDate;
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        $sql = "SELECT DATE_FORMAT($dateColumn, '$format') as period, COUNT(*) as count, SUM($dataColumn) as total, AVG($dataColumn) as average FROM $table $whereSql GROUP BY period ORDER BY period ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Calculate overall totals/average for the filtered set
        $totalSql = "SELECT COUNT(*) as count, SUM($dataColumn) as total, AVG($dataColumn) as average FROM $table $whereSql";
        $totalStmt = $pdo->prepare($totalSql);
        $totalStmt->execute($params);
        $totals = $totalStmt->fetch(PDO::FETCH_ASSOC);
        return [
            'period' => $period,
            'date_column' => $dateColumn,
            'data_column' => $dataColumn,
            'start' => $startDate,
            'end' => $endDate,
            'groups' => $data,
            'totals' => $totals,
        ];
    }

    /**
     * Generate business insights for a grouped report.
     * Adds: best/worst period, trend, top N periods, etc.
     * @param array $report The report array from generate()
     * @param int $topN Number of top periods to include
     * @return array
     */
    public static function businessInsights(array $report, int $topN = 3): array
    {
        $groups = $report['groups'] ?? [];
        if (!$groups) return [];
        // Find best and worst period by total
        $sorted = $groups;
        usort($sorted, fn($a, $b) => $b['total'] <=> $a['total']);
        $best = $sorted[0];
        $worst = $sorted[count($sorted) - 1];
        // Calculate trend (simple: compare first and last period)
        $trend = null;
        if (count($groups) > 1) {
            $first = $groups[0]['total'];
            $last = $groups[count($groups) - 1]['total'];
            if ($last > $first) $trend = 'up';
            elseif ($last < $first) $trend = 'down';
            else $trend = 'flat';
        }
        // Top N periods
        $topPeriods = array_slice($sorted, 0, $topN);
        return [
            'best_period' => $best,
            'worst_period' => $worst,
            'trend' => $trend,
            'top_periods' => $topPeriods,
        ];
    }

    /**
     * Generate additional statistics for a grouped report.
     * Returns min, max, median, stddev, and percentiles for totals.
     * @param array $report The report array from generate()
     * @return array
     */
    public static function statistics(array $report): array
    {
        $groups = $report['groups'] ?? [];
        $totals = array_column($groups, 'total');
        if (!$totals) return [];
        sort($totals);
        $count = count($totals);
        $min = min($totals);
        $max = max($totals);
        $mean = array_sum($totals) / $count;
        $median = $count % 2 ? $totals[(int)($count / 2)] : ($totals[$count / 2 - 1] + $totals[$count / 2]) / 2;
        $stddev = sqrt(array_sum(array_map(fn($x) => pow($x - $mean, 2), $totals)) / $count);
        $percentile = function ($p) use ($totals, $count) {
            $k = ($count - 1) * $p;
            $f = floor($k);
            $c = ceil($k);
            if ($f == $c) return $totals[$k];
            return $totals[$f] + ($k - $f) * ($totals[$c] - $totals[$f]);
        };
        return [
            'min' => $min,
            'max' => $max,
            'mean' => $mean,
            'median' => $median,
            'stddev' => $stddev,
            'p25' => $percentile(0.25),
            'p50' => $median,
            'p75' => $percentile(0.75),
        ];
    }
}

//example usage
// if (PHP_SAPI === 'cli') {
//     $report = Report::generate('transactions', 'monthly', '2023-01-01', '2023-12-31');
//     echo json_encode($report, JSON_PRETTY_PRINT);
// }