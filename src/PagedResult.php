<?php

declare(strict_types=1);

namespace Omie\Sdk;

final class PagedResult
{
    private int $page;

    private int $totalPages;

    private array $results;

    public function __construct(int $page, int $totalPages, array $results)
    {
        $this->page = $page;
        $this->totalPages = $totalPages;
        $this->results = $results;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getResults(): array
    {
        return $this->results;
    }
}
