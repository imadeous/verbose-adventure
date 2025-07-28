<?php

namespace Core\Database;

class Paginator extends ReportBuilder
{
    protected int $perPage = 10;
    protected int $currentPage = 1;
    protected int $total = 0;
    protected int $lastPage = 1;
    protected array $pageData = [];

    /**
     * Set the number of results per page.
     * @param int $perPage
     * @return static
     */
    public function perPage(int $perPage): static
    {
        $this->perPage = max(1, $perPage);
        return $this;
    }

    /**
     * Set the current page number.
     * @param int $page
     * @return static
     */
    public function page(int $page): static
    {
        $this->currentPage = max(1, $page);
        return $this;
    }

    /**
     * Generate the paginated report.
     * @param string|null $title
     * @param bool $caption
     * @return array
     */
    protected array $paginatedReport = [];

    /**
     * Run pagination and make chainable. Use getPaginatedReport() to retrieve the result.
     * @param string|null $title
     * @param bool $caption
     * @return static
     */
    public function paginate(?string $title = null, bool $caption = false): static
    {
        // Get total count
        $countBuilder = clone $this;
        $countBuilder->columns = ['COUNT(*) AS total'];
        $countBuilder->operation = 'select';
        $result = $countBuilder->get();
        $this->total = (int)($result[0]['total'] ?? 0);
        $this->lastPage = (int)ceil($this->total / $this->perPage);
        $offset = ($this->currentPage - 1) * $this->perPage;
        $this->limit($this->perPage)->offset($offset);
        $report = $this->generate($title, $caption);
        $report['pagination'] = [
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'from' => $this->total ? $offset + 1 : 0,
            'to' => min($offset + $this->perPage, $this->total),
        ];
        $this->paginatedReport = $report;
        return $this;
    }

    /**
     * Get the paginated report after calling paginate().
     * @return array
     */
    public function getPaginatedReport(): array
    {
        return $this->paginatedReport;
    }
}
