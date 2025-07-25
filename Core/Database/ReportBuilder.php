<?php

namespace Core\Database;

use Core\Database\QueryBuilder;

// $report = ReportBuilder::build('orders')
//     ->forPeriod('2024-01-01', '2024-12-31')
//     ->monthly()
//     ->groupByUser()
//     ->withSum('total_amount')
//     ->withAverage('rating')
//     ->withCount()
//     ->setTitle('Monthly Sales Report')
//     ->generate();

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
    /**
     * Create a new ReportBuilder instance for the given table.
     *
     * @param string $table
     * @return static
     */
    public static function build(string $table, string $dateColumn = 'date'): static
    {
        return new static($table, $dateColumn);
    }

    /**
     * Generate the report data as an array.
     *
     * @return array
     */
    public function generate(): array
    {
        // Add period/group selects and aggregate columns to the select statement
        $selects = [];
        if (!empty($this->selects)) {
            $selects = array_merge($selects, $this->selects);
        }
        if (!empty($this->aggregates)) {
            $selects = array_merge($selects, $this->aggregates);
        }
        if (!empty($selects)) {
            $this->select($selects);
        }
        if (!empty($this->groups)) {
            $this->groupBy($this->groups);
        }

        $results = $this->get();

        return [
            'title' => $this->reportTitle,
            'period' => [
                'from' => $this->startDate,
                'to' => $this->endDate,
            ],
            'columns' => $this->columnAliases,
            'data' => $results,
        ];
    }

    /**
     * Set the reporting period (start and end dates).
     *
     * @param string $start
     * @param string $end
     * @return static
     */
    public function forPeriod(string $start, string $end): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
        // Add date filters to the query
        return $this->where('date', '>=', $start)->where('date', '<=', $end);
    }

    /**
     * Group results by user ID.
     *
     * @return static
     */
    public function groupByUser(): static
    {
        return $this->groupBy('user_id');
    }

    /**
     * Group results by a date column.
     *
     * @param string $column
     * @return static
     */
    public function groupByDate(string $column = 'date'): static
    {
        return $this->groupBy($column);
    }

    /**
     * Add a SUM aggregate for a column.
     *
     * @param string $column
     * @param string|null $alias
     * @return static
     */
    public function withSum(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "sum_{$column}";
        $this->aggregates[] = "SUM(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Add an AVG aggregate for a column.
     *
     * @param string $column
     * @param string|null $alias
     * @return static
     */
    public function withAverage(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "avg_{$column}";
        $this->aggregates[] = "AVG(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Add a MIN aggregate for a column.
     *
     * @param string $column
     * @param string|null $alias
     * @return static
     */
    public function withMin(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "min_{$column}";
        $this->aggregates[] = "MIN(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Add a MAX aggregate for a column.
     *
     * @param string $column
     * @param string|null $alias
     * @return static
     */
    public function withMax(string $column, ?string $alias = null): static
    {
        $alias = $alias ?? "max_{$column}";
        $this->aggregates[] = "MAX(`{$column}`) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Add a COUNT aggregate.
     *
     * @param string $column
     * @param string $alias
     * @return static
     */
    public function withCount(string $column = '*', string $alias = 'count'): static
    {
        $this->aggregates[] = "COUNT({$column}) AS `{$alias}`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Set the report title.
     *
     * @param string $title
     * @return static
     */
    public function setTitle(string $title): static
    {
        $this->reportTitle = $title;
        return $this;
    }

    /**
     * Get the report title, auto-generating if not set.
     *
     * @return string
     */
    public function getTitle(): string
    {
        if ($this->reportTitle) return $this->reportTitle;

        $base = 'Report';
        if ($this->startDate && $this->endDate) {
            $base .= " from {$this->startDate} to {$this->endDate}";
        }

        return $base;
    }

    /**
     * Get the column aliases for the report (aggregate and period columns).
     *
     * @return array
     */
    public function getColumnAliases(): array
    {
        return $this->columnAliases;
    }


    /**
     * Get the report period as an array.
     *
     * @return array|null
     */
    public function getReportPeriod(): ?array
    {
        if ($this->startDate && $this->endDate) {
            return [$this->startDate, $this->endDate];
        }
        return null;
    }

    /**
     * Get custom labels for the report.
     *
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * Convert a prefix and column name to a human-readable label.
     *
     * @param string $prefix
     * @param string $column
     * @return string
     */
    protected function makeLabel(string $prefix, string $column): string
    {
        $parts = array_filter(explode('_', "{$prefix}_{$column}"));
        return ucfirst(implode(' ', array_map('ucfirst', $parts)));
    }

    /**
     * Group by a specific period (hourly, daily, etc.) using the date column.
     *
     * @param string $unit
     * @return static
     */
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

    /**
     * Group by hour.
     *
     * @return static
     */
    public function hourly(): static
    {
        return $this->groupByPeriod('hourly');
    }

    /**
     * Group by day.
     *
     * @return static
     */
    public function daily(): static
    {
        return $this->groupByPeriod('daily');
    }

    /**
     * Group by week.
     *
     * @return static
     */
    public function weekly(): static
    {
        return $this->groupByPeriod('weekly');
    }

    /**
     * Group by month.
     *
     * @return static
     */
    public function monthly(): static
    {
        return $this->groupByPeriod('monthly');
    }

    /**
     * Group by quarter.
     *
     * @return static
     */
    public function quarterly(): static
    {
        return $this->groupByPeriod('quarterly');
    }

    /**
     * Group by year.
     *
     * @return static
     */
    public function annual(): static
    {
        return $this->groupByPeriod('annual');
    }
}
