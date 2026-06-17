<?php

namespace Vendor\Cloudflare\DTOs;

class WorkerScript
{
    public string $id;

    public string $etag;

    public array $handlers;

    public string $last_deployed_from;

    public string $modified_on;

    public string $usage_model;

    public string $compatibility_date;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->etag = (string) ($data['etag'] ?? '');
        $dto->handlers = (array) ($data['handlers'] ?? []);
        $dto->last_deployed_from = (string) ($data['last_deployed_from'] ?? '');
        $dto->modified_on = (string) ($data['modified_on'] ?? '');
        $dto->usage_model = (string) ($data['usage_model'] ?? '');
        $dto->compatibility_date = (string) ($data['compatibility_date'] ?? '');

        return $dto;
    }
}
