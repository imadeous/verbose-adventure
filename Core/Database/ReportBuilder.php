<?php

namespace Core\Database;

use Core\Database\QueryBuilder;

class ReportBuilder extends QueryBuilder
{
    public ?string $startDate = null;
    public ?string $endDate = null;
    public array $aggregates = [];
    public array $columnAliases = [];
    public string $dateColumn = 'date';
    public array $periodSelects = [];
    public array $groups = [];
    public ?string $reportTitle = 'Report';

    public function __construct(string $table, string $dateColumn = 'date')
    {
        parent::__construct($table);
        $this->dateColumn = $dateColumn;
    }

    public static function build(string $table, string $dateColumn = 'date')
    {
        return new static($table, $dateColumn);
    }

    public function forPeriod(string $start, string $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this->where($this->dateColumn, '>=', $start)
            ->where($this->dateColumn, '<=', $end);
    }
}
