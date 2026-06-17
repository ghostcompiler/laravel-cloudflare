<?php

namespace Vendor\Cloudflare\DTOs;

class LogpushJob
{
    public int $id;

    public bool $enabled;

    public string $name;

    public array $logpool_fields;

    public string $destination_conf;

    public string $dataset;

    public string $frequency;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (int) ($data['id'] ?? 0);
        $dto->enabled = (bool) ($data['enabled'] ?? false);
        $dto->name = (string) ($data['name'] ?? '');
        $dto->logpool_fields = (array) ($data['logpool_fields'] ?? []);
        $dto->destination_conf = (string) ($data['destination_conf'] ?? '');
        $dto->dataset = (string) ($data['dataset'] ?? '');
        $dto->frequency = (string) ($data['frequency'] ?? '');

        return $dto;
    }
}
