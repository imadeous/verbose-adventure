<?php
// helpers/Paginator.php

namespace Helpers;

class Paginator
{
    public $items;
    public $total;
    public $perPage;
    public $currentPage;
    public $lastPage;
    public $offset;

    public function __construct(array $items, int $total, int $perPage, int $currentPage)
    {
        $this->items = $items;
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = (int) ceil($total / $perPage);
        $this->offset = ($currentPage - 1) * $perPage;
    }

    public static function paginate(array $allItems, int $perPage = 15, int $currentPage = 1): self
    {
        $total = count($allItems);
        $offset = ($currentPage - 1) * $perPage;
        $items = array_slice($allItems, $offset, $perPage);
        return new self($items, $total, $perPage, $currentPage);
    }

    public function hasPages(): bool
    {
        return $this->lastPage > 1;
    }

    public function previousPage(): ?int
    {
        return $this->currentPage > 1 ? $this->currentPage - 1 : null;
    }

    public function nextPage(): ?int
    {
        return $this->currentPage < $this->lastPage ? $this->currentPage + 1 : null;
    }

    public function pages(): array
    {
        return range(1, $this->lastPage);
    }
}
