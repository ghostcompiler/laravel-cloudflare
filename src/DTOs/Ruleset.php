<?php

namespace Vendor\Cloudflare\DTOs;

class Ruleset
{
    public string $id;

    public string $name;

    public string $description;

    public string $kind;

    public string $version;

    public array $rules;

    public string $phase;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->description = (string) ($data['description'] ?? '');
        $dto->kind = (string) ($data['kind'] ?? '');
        $dto->version = (string) ($data['version'] ?? '');
        $dto->rules = (array) ($data['rules'] ?? []);
        $dto->phase = (string) ($data['phase'] ?? '');

        return $dto;
    }
}
