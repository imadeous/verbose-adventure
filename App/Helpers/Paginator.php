<?php

namespace App\Helpers;

class Paginator

{
    public $totalCount;
    public $perPage;
    public $currentPage;
    public $totalPages;
    public $prevPage;
    public $nextPage;

    public function __construct($totalCount, $perPage = 10, $currentPage = 1)
    {
        $this->totalCount = max(0, (int)$totalCount);
        $this->perPage = max(1, (int)$perPage);
        $this->totalPages = max(1, (int) ceil($this->totalCount / $this->perPage));
        $this->currentPage = max(1, min((int)$currentPage, $this->totalPages));
        $this->prevPage = $this->currentPage > 1 ? $this->currentPage - 1 : null;
        $this->nextPage = $this->currentPage < $this->totalPages ? $this->currentPage + 1 : null;
    }

    public function offset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function hasPrev()
    {
        return $this->prevPage !== null;
    }

    public function hasNext()
    {
        return $this->nextPage !== null;
    }

    public function debugInfo()
    {
        return [
            'totalCount' => $this->totalCount,
            'perPage' => $this->perPage,
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'prevPage' => $this->prevPage,
            'nextPage' => $this->nextPage,
        ];
    }
}
