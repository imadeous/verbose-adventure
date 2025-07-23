<?php

namespace Core\Database;

use Core\Database\ReportBuilder;

class ChartBuilder extends ReportBuilder
{
    /**
     * ChartBuilder provides a fluent interface for building chart configuration and datasets.
     * Supports multiple chart types (bar, line, pie, doughnut), custom options, axes, themes, and datasets.
     *
     * @property string $chartType The type of chart (bar, line, pie, doughnut).
     * @property string $xAxisLabel Label for the X axis.
     * @property string $yAxisLabel Label for the Y axis.
     * @property array $chartOptions Chart configuration options (responsive, plugins, scales, etc.).
     * @property array $customDatasets Custom datasets to be included in the chart.
     *
     * @method static build(string $table, string $dateColumn = 'date') Create a new ChartBuilder instance for a table.
     * @method bar() Set chart type to 'bar'.
     * @method line() Set chart type to 'line'.
     * @method pie() Set chart type to 'pie'.
     * @method doughnut() Set chart type to 'doughnut'.
     * @method responsive(bool $value = true) Enable or disable chart responsiveness.
     * @method title(string $text) Set chart title.
     * @method legend(string $position = 'top') Set legend position.
     * @method scaleY(float|int $min, float|int $max) Set Y axis min/max values.
     * @method scaleX(float|int $min, float|int $max) Set X axis min/max values.
     * @method colors(array $colors) Set chart colors.
     * @method theme(string $name) Set chart theme.
     * @method setXAxis(string $label) Set X axis label.
     * @method setYAxis(string $label) Set Y axis label.
     * @method withOptions(array $options) Merge additional chart options.
     * @method addDataset(string $label, array $data, array $options = []) Add a custom dataset.
     * @method stacked(bool $enable = true) Enable or disable stacked charts.
     * @method multiAxis(array $axesConfig) Configure multiple axes for multi-axis charts.
     * @method toArray() Convert chart configuration and data to array.
     * @method toJson() Convert chart configuration and data to JSON.
     */
    protected string $chartType = 'bar';
    protected string $xAxisLabel = 'Period';
    protected string $yAxisLabel = 'Value';
    protected array $chartOptions = [
        'responsive' => true,
        'plugins' => [
            'legend' => ['display' => true, 'position' => 'top'],
            'title' => ['display' => false, 'text' => ''],
        ],
        'scales' => [],
    ];

    public function bar(): static
    {
        $this->chartType = 'bar';
        return $this;
    }
    public function line(): static
    {
        $this->chartType = 'line';
        return $this;
    }
    public function pie(): static
    {
        $this->chartType = 'pie';
        return $this;
    }
    public function doughnut(): static
    {
        $this->chartType = 'doughnut';
        return $this;
    }

    public function responsive(bool $value = true): static
    {
        $this->chartOptions['responsive'] = $value;
        return $this;
    }

    public function title(string $text): static
    {
        $this->chartOptions['plugins']['title'] = [
            'display' => true,
            'text' => $text
        ];
        return $this;
    }

    public function legend(string $position = 'top'): static
    {
        $this->chartOptions['plugins']['legend']['position'] = $position;
        return $this;
    }

    public function scaleY(float|int $min, float|int $max): static
    {
        $this->chartOptions['scales']['y'] = ['min' => $min, 'max' => $max];
        return $this;
    }

    public function scaleX(float|int $min, float|int $max): static
    {
        $this->chartOptions['scales']['x'] = ['min' => $min, 'max' => $max];
        return $this;
    }

    public function colors(array $colors): static
    {
        $this->chartOptions['colors'] = $colors;
        return $this;
    }

    public function theme(string $name): static
    {
        $this->chartOptions['theme'] = $name;
        return $this;
    }

    public function setXAxis(string $label): static
    {
        $this->xAxisLabel = $label;
        return $this;
    }

    public function setYAxis(string $label): static
    {
        $this->yAxisLabel = $label;
        return $this;
    }

    public function withOptions(array $options): static
    {
        $this->chartOptions = array_merge_recursive($this->chartOptions, $options);
        return $this;
    }

    protected array $customDatasets = [];

    public static function build(string $table, string $dateColumn = 'date'): static
    {
        return new static($table, $dateColumn);
    }

    // Existing chainable methods (bar(), line(), title(), legend(), etc.) omitted for brevity...

    /**
     * Add a custom dataset with label, data array and options.
     * This dataset will be included in the final chart output.
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
     * Enable or disable stacked charts (for bar, line).
     */
    public function stacked(bool $enable = true): static
    {
        $this->chartOptions['scales']['x']['stacked'] = $enable;
        $this->chartOptions['scales']['y']['stacked'] = $enable;
        return $this;
    }

    /**
     * Configure multiple axes for multi-axis charts.
     * Accepts an array of axes config, keyed by axis ID.
     */
    public function multiAxis(array $axesConfig): static
    {
        foreach ($axesConfig as $axisId => $config) {
            $this->chartOptions['scales'][$axisId] = $config;
        }
        return $this;
    }

    /**
     * Override the toArray method to inject custom datasets if any.
     */
    public function toArray(): array
    {
        $report = parent::generate();

        $datasets = $this->customDatasets;

        // If no custom datasets, fall back to using report data as dataset(s)
        if (empty($datasets)) {
            $datasets = [$report['data']]; // Wrap in array for uniformity
        }

        return [
            'title' => $report['title'],
            'type' => $this->chartType,
            'xAxis' => $this->xAxisLabel,
            'yAxis' => $this->yAxisLabel,
            'labels' => array_values($report['columns']),
            'datasets' => $datasets,
            'options' => $this->chartOptions,
        ];
    }

    /**
     * Convert the chart data to JSON format.
     * Useful for passing to JavaScript chart libraries.
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
