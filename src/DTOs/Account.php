<?php

namespace Vendor\Cloudflare\DTOs;

class Account
{
    public string $id;

    public string $name;

    public array $settings;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->settings = (array) ($data['settings'] ?? []);

        return $dto;
    }
}
