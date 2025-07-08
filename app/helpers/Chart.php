<?php
// helpers/Charts.php

namespace Helpers;

class Chart
{
    /**
     * Transpose an array of associative arrays to x and y axes.
     *
     * @param array $data The input data (array of associative arrays)
     * @param string $xField The field to use for the x-axis
     * @param string $yField The field to use for the y-axis
     * @return array [x_values, y_values]
     */
    public static function transpose(array $data, string $xField, string $yField): array
    {
        $x = [];
        $y = [];
        foreach ($data as $row) {
            if (isset($row[$xField]) && isset($row[$yField])) {
                $x[] = $row[$xField];
                $y[] = $row[$yField];
            }
        }
        return [$x, $y];
    }

    /**
     * Group an array of associative arrays by a given field name.
     *
     * @param array $data The input data (array of associative arrays)
     * @param string $groupField The field to group by
     * @return array Grouped data (group value => array of rows)
     */
    public static function groupBy(array $data, string $groupField): array
    {
        $result = [];
        foreach ($data as $row) {
            if (isset($row[$groupField])) {
                $key = $row[$groupField];
                if (!isset($result[$key])) {
                    $result[$key] = [];
                }
                $result[$key][] = $row;
            }
        }
        return $result;
    }

    /**
     * Convert grouped data to Chart.js-compatible datasets.
     * Each group becomes a dataset, with x and y axes as defined.
     *
     * @param array $data Raw data (array of associative arrays)
     * @param string $groupField Field to group by
     * @param string $xField Field to use for x-axis
     * @param string $yField Field to use for y-axis
     * @param array $config Optional Chart.js config (['group' => [...], '*' => [...]] or global)
     * @return array Chart.js compatible array: ['labels' => [...], 'datasets' => [...]]
     */
    public static function toChartJs(array $data, string $groupField, string $xField, string $yField, array $config = []): array
    {
        $groupedData = self::groupBy($data, $groupField);
        $allX = [];
        foreach ($groupedData as $rows) {
            [$xVals,] = self::transpose($rows, $xField, $yField);
            $allX = array_merge($allX, $xVals);
        }
        $labels = array_values(array_unique($allX));
        sort($labels);
        $datasets = [];
        foreach ($groupedData as $group => $rows) {
            [$xVals, $yVals] = self::transpose($rows, $xField, $yField);
            $rowMap = array_combine($xVals, $yVals);
            $dataArr = [];
            foreach ($labels as $label) {
                $dataArr[] = isset($rowMap[$label]) ? $rowMap[$label] : null;
            }
            // Merge config: group-specific > global (*) > default
            $datasetConfig = $config[$group] ?? ($config['*'] ?? []);
            $datasets[] = array_merge([
                'label' => $group,
                'data' => $dataArr
            ], $datasetConfig);
        }
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }
}
