<?php

namespace Vendor\Cloudflare\DTOs;

class ZoneSetting
{
    public string $id;

    public mixed $value;

    public bool $editable;

    public string $modified_on;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->value = $data['value'] ?? null;
        $dto->editable = (bool) ($data['editable'] ?? false);
        $dto->modified_on = (string) ($data['modified_on'] ?? '');

        return $dto;
    }
}
