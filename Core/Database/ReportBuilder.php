<?php

namespace Core\Database;

use Core\Database\QueryBuilder;

// $report = (new ReportBuilder('orders'))
//     ->forPeriod('2024-01-01', '2024-12-31')
//     ->groupByUser()
//     ->withSum('total_amount')
//     ->withAverage('rating')
//     ->withCount()
//     ->setTitle('User Performance Report');

// $data = $report->generate();
// $labels = $report->getLabels();
// $title = $report->getTitle();

class ReportBuilder extends QueryBuilder
{
    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected array $aggregates = [];
    protected array $labels = [];
    protected array $columnAliases = [];
    protected string $dateColumn = 'date'; // Default date column
    protected string $groupByColumn = 'order_id'; // Default group by column
    protected array $selects = [];
    protected array $groups = [];
    protected ?string $reportType = null; // e.g., 'summary', 'detailed'
    protected ?string $reportFormat = null; // e.g., 'json', 'csv', 'html'
    protected ?string $reportDescription = null; // Optional description for the report             
    protected ?string $reportTitle = 'Report'; // Optional title for the report

    public function forPeriod(string $start, string $end): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this->where('date', '>=', $start)->where('date', '<=', $end);
    }

    public function groupByUser(): static
    {
        return $this->groupBy('user_id');
    }

    public function groupByDate(string $column = 'date'): static
    {
        return $this->groupBy($column);
    }

    public function withSum(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "sum_{$column}";
        $this->aggregates[] = "SUM(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    public function withAverage(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "avg_{$column}";
        $this->aggregates[] = "AVG(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    public function withMin(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "min_{$column}";
        $this->aggregates[] = "MIN(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    public function withMax(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "max_{$column}";
        $this->aggregates[] = "MAX(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    public function withCount(string $column = '*', string $alias = 'count'): static
    {
        $this->aggregates[] = "COUNT({$column}) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }


    public function setTitle(string $title): static
    {
        $this->reportTitle = $title;
        return $this;
    }

    public function getTitle(): string
    {
        if ($this->reportTitle) return $this->reportTitle;

        $base = 'Report';
        if ($this->startDate && $this->endDate) {
            $base .= " from {$this->startDate} to {$this->endDate}";
        }

        return $base;
    }

    public function generate(): array
    {
        if (!empty($this->aggregates)) {
            $this->select($this->aggregates);
        }

        return $this->get();
    }

    public function getReportPeriod(): ?array
    {
        if ($this->startDate && $this->endDate) {
            return [$this->startDate, $this->endDate];
        }
        return null;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * Convert something like "sum", "total_sales" to "Total Sales"
     */
    protected function makeLabel(string $prefix, string $column): string
    {
        $parts = array_filter(explode('_', "{$prefix}_{$column}"));
        return ucfirst(implode(' ', array_map('ucfirst', $parts)));
    }

    // Group by a specific period (hourly, daily, etc.)
    // This allows for flexible grouping based on the date column
    public function groupByPeriod(string $unit): static
    {
        $periodExpressions = [
            'hourly' => "DATE_FORMAT({$this->dateColumn}, '%Y-%m-%d %H:00:00')",
            'daily' => "DATE({$this->dateColumn})",
            'weekly' => "YEARWEEK({$this->dateColumn}, 1)", // ISO week
            'monthly' => "DATE_FORMAT({$this->dateColumn}, '%Y-%m')",
            'quarterly' => "CONCAT(YEAR({$this->dateColumn}), '-Q', QUARTER({$this->dateColumn}))",
            'annual' => "YEAR({$this->dateColumn})"
        ];

        $alias = "period_{$unit}";
        $this->selects[] = "{$periodExpressions[$unit]} AS {$alias}";
        $this->groups[] = $alias;
        $this->columnAliases[$alias] = ucfirst($unit);

        return $this;
    }

    public function hourly(): static
    {
        return $this->groupByPeriod('hourly');
    }

    public function daily(): static
    {
        return $this->groupByPeriod('daily');
    }

    public function weekly(): static
    {
        return $this->groupByPeriod('weekly');
    }

    public function monthly(): static
    {
        return $this->groupByPeriod('monthly');
    }

    public function quarterly(): static
    {
        return $this->groupByPeriod('quarterly');
    }

    public function annual(): static
    {
        return $this->groupByPeriod('annual');
    }
}
