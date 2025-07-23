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
    protected ?string $reportTitle = null;

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

    public function withSum(string $column, string $alias): static
    {
        $alias ??= "sum_{$column}";
        $this->aggregates[] = "SUM({$column}) AS {$alias}";
        $this->labels[$alias] = $this->makeLabel("sum", $column);
        return $this;
    }

    public function withAverage(string $column, string $alias): static
    {
        $alias ??= "avg_{$column}";
        $this->aggregates[] = "AVG({$column}) AS {$alias}";
        $this->labels[$alias] = $this->makeLabel("avg", $column);
        return $this;
    }

    public function withCount(string $column = '*', string $alias = 'count'): static
    {
        $this->aggregates[] = "COUNT({$column}) AS {$alias}";
        $label = $column === '*' ? "Total Count" : "Count of {$this->makeLabel('',$column)}";
        $this->labels[$alias] = $label;
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
}
