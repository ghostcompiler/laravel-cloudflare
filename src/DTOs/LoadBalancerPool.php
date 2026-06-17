<?php

namespace Vendor\Cloudflare\DTOs;

class LoadBalancerPool
{
    public string $id;

    public string $name;

    public string $description;

    public bool $enabled;

    public int $minimum_origins;

    public string $monitor;

    public string $notification_email;

    public array $origins;

    public array $check_regions;

    public float $latitude;

    public float $longitude;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->description = (string) ($data['description'] ?? '');
        $dto->enabled = (bool) ($data['enabled'] ?? false);
        $dto->minimum_origins = (int) ($data['minimum_origins'] ?? 0);
        $dto->monitor = (string) ($data['monitor'] ?? '');
        $dto->notification_email = (string) ($data['notification_email'] ?? '');
        $dto->origins = (array) ($data['origins'] ?? []);
        $dto->check_regions = (array) ($data['check_regions'] ?? []);
        $dto->latitude = (float) ($data['latitude'] ?? 0.0);
        $dto->longitude = (float) ($data['longitude'] ?? 0.0);

        return $dto;
    }
}
