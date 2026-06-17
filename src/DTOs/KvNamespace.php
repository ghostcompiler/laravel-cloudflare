<?php

namespace Vendor\Cloudflare\DTOs;

class KvNamespace
{
    public string $id;

    public string $title;

    public bool $supports_url_encoding;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->title = (string) ($data['title'] ?? '');
        $dto->supports_url_encoding = (bool) ($data['supports_url_encoding'] ?? false);

        return $dto;
    }
}
