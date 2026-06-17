<?php

namespace Vendor\Cloudflare\DTOs;

class PageRule
{
    public string $id;

    public array $targets;

    public array $actions;

    public int $priority;

    public string $status;

    public string $created_on;

    public string $modified_on;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->targets = (array) ($data['targets'] ?? []);
        $dto->actions = (array) ($data['actions'] ?? []);
        $dto->priority = (int) ($data['priority'] ?? 0);
        $dto->status = (string) ($data['status'] ?? '');
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->modified_on = (string) ($data['modified_on'] ?? '');

        return $dto;
    }
}
