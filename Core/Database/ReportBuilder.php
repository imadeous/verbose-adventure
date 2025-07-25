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
    protected array $groups = [];
    protected ?string $reportTitle = 'Report';

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

    // -------
    // GENERATE REPORT 
    /**
     * Generate the report with the specified title.
     *
     * @param string|null $title
     * @return array
     */
    public function generate(?string $title = null)
    {
        if ($title !== null) {
            $this->reportTitle = $title;
        }
        // Use aggregates if set, otherwise select all
        $selects = array_merge($this->periodSelects, $this->aggregates);
        $this->columns = $selects;
        $this->operation = 'select';
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
    public function forPeriod(string $start, string $end): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
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
     * Add a GROUP BY clause.
     *
     * @param string $column
     * @return static
     */
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
        var_dump($this);
        return $this;
    }
}
