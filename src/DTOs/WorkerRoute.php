<?php

namespace Vendor\Cloudflare\DTOs;

class WorkerRoute
{
    public string $id;

    public string $pattern;

    public string $script;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->pattern = (string) ($data['pattern'] ?? '');
        $dto->script = (string) ($data['script'] ?? '');

        return $dto;
    }
}
