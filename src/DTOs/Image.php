<?php

namespace Vendor\Cloudflare\DTOs;

class Image
{
    public string $id;

    public string $filename;

    public array $metadata;

    public bool $requireSignedURLs;

    public array $variants;

    public string $uploaded;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->filename = (string) ($data['filename'] ?? '');
        $dto->metadata = (array) ($data['metadata'] ?? []);
        $dto->requireSignedURLs = (bool) ($data['requireSignedURLs'] ?? false);
        $dto->variants = (array) ($data['variants'] ?? []);
        $dto->uploaded = (string) ($data['uploaded'] ?? '');

        return $dto;
    }
}
