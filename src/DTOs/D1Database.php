<?php

namespace Vendor\Cloudflare\DTOs;

class D1Database
{
    public string $uuid;

    public string $name;

    public string $created_at;

    public string $version;

    public int $file_size;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->uuid = (string) ($data['uuid'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->created_at = (string) ($data['created_at'] ?? '');
        $dto->version = (string) ($data['version'] ?? '');
        $dto->file_size = (int) ($data['file_size'] ?? 0);

        return $dto;
    }
}
