<?php

namespace Core\Database;

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
    protected array $columnAliases = [];
    protected string $dateColumn = 'date';
    protected array $periodSelects = [];
    protected ?string $reportTitle = 'Report';
    protected bool $aggregatePeriod = false;

    /**
     * ReportBuilder constructor.
     *
     * @param string $table The table to report on.
     * @param string $dateColumn The date column for period filtering.
     */
    public function __construct(string $table, string $dateColumn = 'date')
    {
        parent::__construct($table);
        $this->dateColumn = $dateColumn;
    }

    /**
     * Create a new ReportBuilder instance.
     *
     * @param string $table The table to report on.
     * @param string $dateColumn The date column for period filtering.
     * @return static
     */
    public static function build(string $table, string $dateColumn = 'date'): static
    {
        return new static($table, $dateColumn);
    }

    /**
     * Generate the report with the specified title and caption.
     *
     * @param string|null $title The title of the report.
     * @param bool $caption Whether to include a caption.
     * @return array The generated report data.
     */
    public function generate(?string $title = null, bool $caption = false)
    {
        if ($title !== null) {
            $this->reportTitle = $title;
        }
        if ($this->aggregatePeriod) {
            $this->groups = [];
            $this->periodSelects = [];
        }
        $selects = array_merge($this->periodSelects, $this->aggregates);
        $this->columns = $selects;
        $this->operation = 'select';
        $results = $this->get();

        $autoCaption = null;
        if ($caption) {
            // Map period aliases to grouping type
            $periodTypes = [
                'period_day' => 'Daily ',
                'period_week' => 'Weekly ',
                'period_month' => 'Monthly ',
                'period_quarter' => 'Quarterly ',
                'period_year' => 'Annual ',
            ];
            $groupType = '';
            foreach ($periodTypes as $key => $label) {
                if (isset($this->columnAliases[$key])) {
                    $groupType = $label;
                    break;
                }
            }

            $columns = array_filter($this->columnAliases, fn($k) => strpos($k, 'period_') !== 0, ARRAY_FILTER_USE_KEY);
            $columnList = implode(', ', $columns);

            $autoCaption = trim(
                $groupType .
                    ucfirst($this->table) . ' report from ' .
                    $this->startDate . ' to ' . $this->endDate .
                    ($columnList ? ' with ' . $columnList : '')
            );
        }

        // If empty nodes are requested, fill in missing periods
        if ($this->withEmptyNodes && !empty($this->periodSelects) && $this->startDate && $this->endDate) {
            // Only works for daily, weekly, monthly, quarterly, yearly
            $periodKey = array_keys($this->columnAliases, 'Day')[0] ??
                array_keys($this->columnAliases, 'Week')[0] ??
                array_keys($this->columnAliases, 'Month')[0] ??
                array_keys($this->columnAliases, 'Quarter')[0] ??
                array_keys($this->columnAliases, 'Year')[0] ?? null;

            if ($periodKey) {
                $filled = [];
                // Build all periods in range
                $periods = [];
                if ($periodKey === 'period_day') {
                    $start = new \DateTime($this->startDate);
                    $end = new \DateTime($this->endDate);
                    while ($start <= $end) {
                        $periods[] = $start->format('Y-m-d');
                        $start->modify('+1 day');
                    }
                } elseif ($periodKey === 'period_month') {
                    $start = new \DateTime($this->startDate);
                    $end = new \DateTime($this->endDate);
                    $start->modify('first day of this month');
                    $end->modify('first day of next month');
                    while ($start < $end) {
                        $periods[] = $start->format('Y-m');
                        $start->modify('+1 month');
                    }
                } elseif ($periodKey === 'period_year') {
                    $start = (int)date('Y', strtotime($this->startDate));
                    $end = (int)date('Y', strtotime($this->endDate));
                    for ($y = $start; $y <= $end; $y++) {
                        $periods[] = (string)$y;
                    }
                }
                // Fill missing nodes
                $existing = [];
                foreach ($results as $row) {
                    $existing[$row[$periodKey]] = $row;
                }
                foreach ($periods as $p) {
                    if (isset($existing[$p])) {
                        $filled[] = $existing[$p];
                    } else {
                        $empty = [$periodKey => $p];
                        foreach ($this->columnAliases as $k => $v) {
                            if ($k !== $periodKey) $empty[$k] = null;
                        }
                        $filled[] = $empty;
                    }
                }
                $results = $filled;
            }
        }

        // Add summary row if enabled
        $summary = [];
        if ($this->withSummary && !empty($results)) {
            // Find the first numeric aggregate column (skip period columns)
            $numericKey = null;
            foreach ($this->columnAliases as $key => $label) {
                if (strpos($key, 'period_') === 0) continue;
                // Check if the column is numeric in the first row
                if (isset($results[0][$key]) && is_numeric($results[0][$key])) {
                    $numericKey = $key;
                    break;
                }
            }
            if ($numericKey) {
                $values = array_column($results, $numericKey);
                $total = array_sum($values);
                $summary['Report Total'] = $total;
                $summary['Report Average'] = count($values) ? $total / count($values) : 0;
                $summary['Report Count'] = $total;
            }
        }

        return [
            'title' => $this->reportTitle,
            'caption' => $autoCaption,
            'period' => [
                'from' => $this->startDate,
                'to' => $this->endDate,
            ],
            'columns' => $this->columnAliases,
            'data' => $results,
            'summary' => $summary,
        ];
    }
    // -------
    // PERIOD HANDLING
    // -------  

    /**
     * Set the date range for the report.
     *
     * @param string $start Start date in 'Y-m-d' format.
     * @param string $end End date in 'Y-m-d' format.
     * @return static
     */
    public function forPeriod(string $start, string $end, bool $aggregatePeriod = false): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
        $this->aggregatePeriod = $aggregatePeriod;
        return $this->where($this->dateColumn, '>=', $start)
            ->where($this->dateColumn, '<=', $end);
    }

    /**
     * Get the start date of the report period.
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * Get the end date of the report period.
     *
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    // -------
    // AGGREGATES
    // -------

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
     * Add a COUNT aggregate for a column.
     *
     * @param string $column
     * @param string|null $alias
     * @return static
     */
    public function withCount(string $column = '*', ?string $alias = 'count'): static
    {
        $this->aggregates[] = "COUNT({$column}) AS `{$alias}`";
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
     * Add a percentage aggregate for a column.
     * Calculates (SUM(column) / COUNT(column) * base) * 100 as percentage.
     * @param string $column The column to aggregate.
     * @param float|int $base The max score or denominator multiplier.
     * @param string|null $alias The alias for the result column.
     * @return static
     */
    public function withPercentage(string $column, ?string $alias = null, float|int $base = 10): static
    {
        $alias = $alias ?? "percent_{$column}";
        // (SUM(column) / COUNT(column) * base) * 100
        $expr = "((SUM(`$column`) / NULLIF(COUNT(`$column`), 0)) / $base) * 100";
        $this->aggregates[] = "$expr AS `$alias`";
        $this->columnAliases[$alias] = ucwords(str_replace('_', ' ', $alias));
        return $this;
    }

    /**
     * Include non-numerical columns in the report output.
     * @param string|array $columns Column name or array of column names.
     * @return static
     */
    public function with(string|array $columns): static
    {
        foreach ((array)$columns as $col) {
            $this->aggregates[] = "`$col`";
            $this->columnAliases[$col] = ucwords(str_replace('_', ' ', $col));
        }
        return $this;
    }

    /**
     * Enable summary row with Report Total, Report Average, and Report Count.
     * @var bool
     */
    protected bool $withSummary = false;

    /**
     * Call to add summary row (Report Total, Report Average, Report Count) for the first numeric aggregate column.
     * @return static
     */
    public function withSummary(): static
    {
        $this->withSummary = true;
        return $this;
    }

    // -------
    // PERIOD GROUPING 
    // -------

    /**
     * Group results by day using the date column.
     * @param string|null $alias
     * @return static
     */
    public function daily(?string $alias = 'period_day')
    {
        $expression = "DATE_FORMAT({$this->dateColumn}, '%Y-%m-%d')";
        $this->periodSelects[] = "$expression AS {$alias}";
        $this->groups[] = $expression;
        $this->columnAliases[$alias] = 'Day';
        return $this;
    }

    /**
     * Group results by week using the date column.
     * @param string|null $alias
     * @return static
     */
    public function weekly(?string $alias = 'period_week')
    {
        $expression = "YEAR({$this->dateColumn}), WEEK({$this->dateColumn}, 1)";
        $this->periodSelects[] = "CONCAT(YEAR({$this->dateColumn}), '-', LPAD(WEEK({$this->dateColumn}, 1), 2, '0')) AS {$alias}";
        $this->groups[] = "YEAR({$this->dateColumn})";
        $this->groups[] = "WEEK({$this->dateColumn}, 1)";
        $this->columnAliases[$alias] = 'Week';
        return $this;
    }

    /**
     * Group results by month using the date column.
     *
     * @param string|null $alias
     * @return static
     */
    public function monthly(?string $alias = 'period_month')
    {
        $expression = "DATE_FORMAT({$this->dateColumn}, '%Y-%m')";
        $this->periodSelects[] = "$expression AS {$alias}";
        $this->groups[] = $expression;
        $this->columnAliases[$alias] = 'Month';
        return $this;
    }

    /**
     * Group results by quarter using the date column.
     * @param string|null $alias
     * @return static
     */
    public function quarterly(?string $alias = 'period_quarter')
    {
        $expression = "YEAR({$this->dateColumn}), QUARTER({$this->dateColumn})";
        $this->periodSelects[] = "CONCAT(YEAR({$this->dateColumn}), '-Q', QUARTER({$this->dateColumn})) AS {$alias}";
        $this->groups[] = "YEAR({$this->dateColumn})";
        $this->groups[] = "QUARTER({$this->dateColumn})";
        $this->columnAliases[$alias] = 'Quarter';
        return $this;
    }

    /**
     * Group results by year using the date column.
     * @param string|null $alias
     * @return static
     */
    public function yearly(?string $alias = 'period_year')
    {
        $expression = "YEAR({$this->dateColumn})";
        $this->periodSelects[] = "$expression AS {$alias}";
        $this->groups[] = $expression;
        $this->columnAliases[$alias] = 'Year';
        return $this;
    }

    /**********************************************
     * Add support for empty nodes in period range *
     **********************************************/
    protected bool $withEmptyNodes = false;

    /**
     * Toggle inclusion of empty nodes (periods with no data).
     * Useful for charting to keep the x-axis continuous.
     *
     * @param bool $enable
     * @return static
     */
    public function withEmptyNodes(bool $enable = true): static
    {
        $this->withEmptyNodes = $enable;
        return $this;
    }
}
