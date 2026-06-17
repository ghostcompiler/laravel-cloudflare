<?php

namespace Vendor\Cloudflare\DTOs;

class R2Bucket
{
    public string $name;

    public string $creation_date;

    public string $location;

    public string $storage_class;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->name = (string) ($data['name'] ?? '');
        $dto->creation_date = (string) ($data['creation_date'] ?? '');
        $dto->location = (string) ($data['location'] ?? '');
        $dto->storage_class = (string) ($data['storage_class'] ?? '');

        return $dto;
    }
}
