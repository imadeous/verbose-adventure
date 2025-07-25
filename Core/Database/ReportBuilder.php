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

    public function __construct(string $table, string $dateColumn = 'date')
    {
        parent::__construct($table);
        $this->dateColumn = $dateColumn;
    }

    public static function build(string $table, string $dateColumn = 'date'): static
    {
        return new static($table, $dateColumn);
    }

    public function generate(?string $title = null)
    {
        if ($title !== null) {
            $this->reportTitle = $title;
        }
        // Use aggregates if set, otherwise select all
        $selects = !empty($this->aggregates) ? $this->aggregates : ['*'];
        $this->columns = [];
        parent::select($selects);
        $results = parent::get();
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


    public function forPeriod(string $start, string $end): static
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this->where($this->dateColumn, '>=', $start)
            ->where($this->dateColumn, '<=', $end);
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
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
}
