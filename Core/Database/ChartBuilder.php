<?php

namespace Core\Database;

use Core\Database\ReportBuilder;

class ChartBuilder extends ReportBuilder

{

    protected string $chartType = 'bar';
    protected array $chartOptions = [
        'responsive' => true,
        'plugins' => [
            'legend' => ['display' => true, 'position' => 'top'],
            'title' => ['display' => false, 'text' => ''],
        ],
        'scales' => [],
    ];
    protected array $customDatasets = [];

    /**
     * Create a new ChartBuilder instance for a table and date column.
     * @param string $table The table to report/chart on.
     * @param string $dateColumn The date column for period filtering.
     * @return static
     */
    public static function build(string $table, string $dateColumn = 'date'): static
    {
        return new static($table, $dateColumn);
    }

    /**
     * Set chart type to 'bar'.
     * @return static
     */
    public function bar(): static
    {
        $this->chartType = 'bar';
        return $this;
    }

    /**
     * Set chart type to 'line'.
     * @return static
     */
    public function line(): static
    {
        $this->chartType = 'line';
        return $this;
    }

    /**
     * Set chart type to 'pie'.
     * @return static
     */
    public function pie(): static
    {
        $this->chartType = 'pie';
        return $this;
    }

    /**
     * Set chart type to 'doughnut'.
     * @return static
     */
    public function doughnut(): static
    {
        $this->chartType = 'doughnut';
        return $this;
    }

    /**
     * Configure a mixed bar-line chart with auto-detected datasets and custom type/yAxisID per metric.
     *
     * @param array $datasetTypes Associative array: ['Metric Label' => ['type' => 'bar'|'line', 'yAxisID' => 'y'|'y1', ...]]
     * @return static
     */
    public function mixedChart(array $datasetTypes = []): static
    {
        $this->chartType = 'bar'; // Chart.js requires a base type for mixed charts
        $this->chartOptions['scales'] = $this->chartOptions['scales'] ?? [];

        // Mark for mixed chart rendering in toArray()
        $this->chartOptions['isMixedChart'] = true;
        $this->chartOptions['mixedDatasetTypes'] = $datasetTypes;
        return $this;
    }

    /**
     * Enable or disable Chart.js responsiveness.
     * @param bool $value
     * @return static
     */
    public function responsive(bool $value = true): static
    {
        $this->chartOptions['responsive'] = $value;
        return $this;
    }

    /**
     * Set the chart title (Chart.js plugin).
     * @param string $text
     * @return static
     */
    public function title(string $text): static
    {
        $this->chartOptions['plugins']['title'] = ['display' => true, 'text' => $text];
        return $this;
    }

    /**
     * Set legend options for Chart.js plugin.
     * Accepts either a string (position) or an array of legend options.
     * @param string|array $options Legend position as string, or full legend options as array.
     * @return static
     */
    public function legend(string|array $options = 'top'): static
    {
        if (is_array($options)) {
            $this->chartOptions['plugins']['legend'] = array_merge(
                $this->chartOptions['plugins']['legend'],
                $options
            );
        } else {
            $this->chartOptions['plugins']['legend']['position'] = $options;
        }
        return $this;
    }

    /**
     * Set Y axis min/max values (Chart.js scales).
     * @param float|int $min
     * @param float|int $max
     * @return static
     */
    public function scaleY(float|int $min, float|int $max): static
    {
        $this->chartOptions['scales']['y'] = ['min' => $min, 'max' => $max];
        return $this;
    }

    /**
     * Set X axis min/max values (Chart.js scales).
     * @param float|int $min
     * @param float|int $max
     * @return static
     */
    public function scaleX(float|int $min, float|int $max): static
    {
        $this->chartOptions['scales']['x'] = ['min' => $min, 'max' => $max];
        return $this;
    }

    /**
     * Set chart colors (custom, not Chart.js native).
     * @param array $colors
     * @return static
     */
    public function colors(array $colors): static
    {
        $this->chartOptions['colors'] = $colors;
        return $this;
    }

    /**
     * Set chart theme (custom, not Chart.js native).
     * @param string $name
     * @return static
     */
    public function theme(string $name): static
    {
        $this->chartOptions['theme'] = $name;
        return $this;
    }

    /**
     * Merge additional Chart.js options (deep merge).
     * @param array $options
     * @return static
     */
    public function withOptions(array $options): static
    {
        $this->chartOptions = array_merge_recursive($this->chartOptions, $options);
        return $this;
    }

    /**
     * Enable or disable stacked charts (bar, line).
     * @param bool $enable
     * @return static
     */
    public function stacked(bool $enable = true): static
    {
        $this->chartOptions['scales']['x']['stacked'] = $enable;
        $this->chartOptions['scales']['y']['stacked'] = $enable;
        return $this;
    }

    /**
     * Configure multiple axes for multi-axis charts.
     * @param array $axesConfig Array of axes config, keyed by axis ID (e.g. 'y', 'y1').
     * @return static
     */
    public function multiAxis(array $axesConfig): static
    {
        foreach ($axesConfig as $axisId => $config) {
            $this->chartOptions['scales'][$axisId] = $config;
        }
        return $this;
    }

    /**
     * Add a custom dataset for Chart.js datasets array.
     * @param string $label Dataset label.
     * @param array $data Data array for the dataset.
     * @param array $options Additional Chart.js dataset options.
     * @return static
     */
    public function addDataset(string $label, array $data, array $options = []): static
    {
        $this->customDatasets[] = array_merge([
            'label' => $label,
            'data' => $data,
        ], $options);
        return $this;
    }

    /**
     * Output Chart.js config array, using ReportBuilder's fluent API for data aggregation.
     * Labels are period or group values, datasets are values for each metric.
     * @return array Chart.js config array.
     */
    public function toArray(): array
    {
        $report = parent::generate();
        $labels = [];
        $datasets = [];

        // If custom datasets are set, use them directly
        if (!empty($this->customDatasets)) {
            $datasets = $this->customDatasets;
            // Try to extract labels from first dataset if possible
            if (isset($datasets[0]['data']) && is_array($datasets[0]['data'])) {
                $labels = array_keys($datasets[0]['data']);
            }
        } else {
            // Otherwise, build datasets from report data
            $columns = $report['columns'];
            $data = $report['data'];
            // Find label column (period, group, etc.)
            $labelKey = null;
            foreach ($columns as $key => $name) {
                if (stripos($key, 'period_') === 0 || stripos($name, 'Day') !== false || stripos($name, 'Month') !== false || stripos($name, 'Year') !== false || stripos($name, 'Week') !== false || stripos($name, 'Quarter') !== false) {
                    $labelKey = $key;
                    break;
                }
            }
            if ($labelKey) {
                $labels = array_map(fn($row) => $row[$labelKey], $data);
            }
            // For each metric column, build a dataset
            foreach ($columns as $key => $name) {
                if ($key === $labelKey) continue;
                $datasets[] = [
                    'label' => $name,
                    'data' => array_map(fn($row) => $row[$key], $data),
                ];
            }
        }


        // Mixed chart: assign type/yAxisID per dataset if requested
        if (!empty($this->chartOptions['isMixedChart']) && !empty($this->chartOptions['mixedDatasetTypes'])) {
            foreach ($datasets as &$dataset) {
                $label = $dataset['label'] ?? null;
                if ($label && isset($this->chartOptions['mixedDatasetTypes'][$label])) {
                    foreach ($this->chartOptions['mixedDatasetTypes'][$label] as $key => $value) {
                        $dataset[$key] = $value;
                    }
                }
            }
            unset($dataset);
        }

        // Apply colors to dataset for pie/doughnut charts
        if (in_array($this->chartType, ['pie', 'doughnut']) && !empty($this->chartOptions['colors'])) {
            foreach ($datasets as &$dataset) {
                $dataset['backgroundColor'] = $this->chartOptions['colors'];
            }
            unset($dataset);
        }

        return [
            'type' => $this->chartType,
            'data' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => $this->chartOptions,
        ];
    }

    /**
     * Output Chart.js config as JSON string.
     * @return string JSON config for Chart.js.
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
// Example usage:
// $chart = ChartBuilder::build('ratings')
//     ->forPeriod('2024-01-01', '2024-12-31')
//     ->monthly()
//     ->withAverage('rating')
//     ->line()
//     ->title('User Rating Trend')
//     ->legend('bottom')
//     ->scaleY(0, 5)
//     ->scaleX(0, 12)
//     ->responsive()
//     ->colors(['#00AEEF', '#F25C05'])
//     ->theme('dark')
//     ->toJson();

// $chart = ChartBuilder::build('sales')
//     ->forPeriod('2024-01-01', '2024-12-31')
//     ->monthly()
//     ->addDataset('Custom Sales', [10, 20, 15, 30], ['backgroundColor' => '#FF6384'])
//     ->addDataset('Target Sales', [12, 22, 18, 28], ['backgroundColor' => '#36A2EB'])
//     ->bar()
//     ->stacked(true)
//     ->title('Stacked Sales Chart')
//     ->toJson();

// $chart = ChartBuilder::build('metrics')
//     ->forPeriod('2024-01-01', '2024-12-31')
//     ->monthly()
//     ->withSum('revenue')
//     ->withAverage('conversion_rate')
//     ->bar()
//     ->multiAxis([
//         'y' => ['type' => 'linear', 'position' => 'left', 'title' => ['display' => true, 'text' => 'Revenue']],
//         'y1' => ['type' => 'linear', 'position' => 'right', 'title' => ['display' => true, 'text' => 'Conversion Rate'], 'grid' => ['drawOnChartArea' => false]],
//     ])
//     ->title('Revenue vs Conversion Rate')
//     ->toJson();
