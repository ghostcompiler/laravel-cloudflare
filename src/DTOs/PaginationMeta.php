<?php

namespace Vendor\Cloudflare\DTOs;

class PaginationMeta
{
    public int $page;

    public int $perPage;

    public ?int $previousPage;

    public ?int $nextPage;

    public int $lastPage;

    public int $totalEntries;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->page = (int) ($data['page'] ?? 0);
        $dto->perPage = (int) ($data['per_page'] ?? 0);
        $dto->previousPage = isset($data['previous_page']) ? (int) $data['previous_page'] : null;
        $dto->nextPage = isset($data['next_page']) ? (int) $data['next_page'] : null;
        $dto->lastPage = (int) ($data['last_page'] ?? 0);
        $dto->totalEntries = (int) ($data['total_entries'] ?? 0);

        return $dto;
    }
}
