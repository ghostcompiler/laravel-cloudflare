<?php

namespace Vendor\Cloudflare\DTOs;

class AccessApplication
{
    public string $id;

    public string $name;

    public string $domain;

    public string $type;

    public string $created_at;

    public string $updated_at;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->domain = (string) ($data['domain'] ?? '');
        $dto->type = (string) ($data['type'] ?? '');
        $dto->created_at = (string) ($data['created_at'] ?? '');
        $dto->updated_at = (string) ($data['updated_at'] ?? '');

        return $dto;
    }
}
