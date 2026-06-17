<?php

namespace Vendor\Cloudflare\DTOs;

class EmailRoutingRule
{
    public string $id;

    public string $tag;

    public string $name;

    public bool $enabled;

    public array $matchers;

    public array $actions;

    public int $priority;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->tag = (string) ($data['tag'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->enabled = (bool) ($data['enabled'] ?? false);
        $dto->matchers = (array) ($data['matchers'] ?? []);
        $dto->actions = (array) ($data['actions'] ?? []);
        $dto->priority = (int) ($data['priority'] ?? 0);

        return $dto;
    }
}
