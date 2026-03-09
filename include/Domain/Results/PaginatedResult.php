<?php

namespace PluginTemplate\Inc\Domain\Results;

class PaginatedResult
{
    public readonly int $total_pages;

    /**
     * @param array $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $per_page,
        public readonly int $current_page,
    ) 
    {
        $this->total_pages = $this->totalPages();
    }

    public function totalPages(): int
    {
        if ($this->per_page === 0) {
            return 0;
        }

        return (int) ceil($this->total / $this->per_page);
    }

    public function hasNextPage(): bool
    {
        return $this->current_page < $this->totalPages();
    }

    public function hasPreviousPage(): bool
    {
        return $this->current_page > 1;
    }
}