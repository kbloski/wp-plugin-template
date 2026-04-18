<?php

namespace PluginTemplate\Inc\Shared\Common;

class PaginatedResult
{
    public array $items;
    public int $totalCount;
    public int $page;
    public int $pageSize;
    public int $totalPages;

    public function __construct(array $items, int $totalCount, int $page, int $pageSize)
    {
        $this->items = $items;
        $this->totalCount = $totalCount;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->totalPages = (int) ceil($totalCount / $pageSize);
    }

    public static function create(array $items, int $totalCount, int $page, int $pageSize): self
    {
        return new self($items, $totalCount, $page, $pageSize);
    }
}