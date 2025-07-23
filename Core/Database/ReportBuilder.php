<?php

namespace Core\Database;

use Core\Database\Db;
use Core\Database\QueryBuilder;
// $report = (new ReportBuilder('orders'))
//     ->forPeriod('2025-01-01', '2025-07-01')
//     ->groupByUser()
//     ->withSum('total_amount', 'total_spent')
//     ->withCount('id', 'order_count')
//     ->generate();
class ReportBuilder extends QueryBuilder
{
    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected array $aggregates = [];

    public function __construct(string $table)
    {
        parent::__construct($table, Db::instance());
    }

    /**
     * Set a date range for the report
     */
    public function forPeriod(string $start, string $end): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this
            ->where('date', '>=', $start)
            ->where('date', '<=', $end);
    }

    /**
     * Group report results by user_id
     */
    public function groupByUser(): static
    {
        return $this->groupBy('user_id');
    }

    /**
     * Group report results by a date column (default: 'date')
     */
    public function groupByDate(string $column = 'date'): static
    {
        return $this->groupBy($column);
    }

    /**
     * Add SUM aggregation for a column
     */
    public function withSum(string $column, string $alias): static
    {
        $this->aggregates[] = "SUM({$column}) AS {$alias}";
        return $this;
    }

    /**
     * Add AVG aggregation for a column
     */
    public function withAverage(string $column, string $alias): static
    {
        $this->aggregates[] = "AVG({$column}) AS {$alias}";
        return $this;
    }

    /**
     * Add COUNT aggregation (default: COUNT(*))
     */
    public function withCount(string $column = '*', string $alias = 'count'): static
    {
        $this->aggregates[] = "COUNT({$column}) AS {$alias}";
        return $this;
    }

    /**
     * Build the final query and return the result
     */
    public function generate(): array
    {
        if (!empty($this->aggregates)) {
            $this->select($this->aggregates);
        }

        return $this->get();
    }

    /**
     * Get the currently set reporting period
     */
    public function getReportPeriod(): ?array
    {
        if ($this->startDate && $this->endDate) {
            return [$this->startDate, $this->endDate];
        }
        return null;
    }
}
