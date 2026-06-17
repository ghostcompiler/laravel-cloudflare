<?php

namespace Vendor\Cloudflare\DTOs;

class FirewallRule
{
    public string $id;

    public bool $paused;

    public string $description;

    public string $action;

    public int $priority;

    public array $filter;

    public array $products;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->paused = (bool) ($data['paused'] ?? false);
        $dto->description = (string) ($data['description'] ?? '');
        $dto->action = (string) ($data['action'] ?? '');
        $dto->priority = (int) ($data['priority'] ?? 0);
        $dto->filter = (array) ($data['filter'] ?? []);
        $dto->products = (array) ($data['products'] ?? []);

        return $dto;
    }
}
