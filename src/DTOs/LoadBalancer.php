<?php

namespace Vendor\Cloudflare\DTOs;

class LoadBalancer
{
    public string $id;

    public string $name;

    public string $description;

    public bool $enabled;

    public int $ttl;

    public string $fallback_pool;

    public array $default_pools;

    public array $region_pools;

    public array $pop_pools;

    public bool $proxied;

    public string $steering_policy;

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
        $dto->ttl = (int) ($data['ttl'] ?? 0);
        $dto->fallback_pool = (string) ($data['fallback_pool'] ?? '');
        $dto->default_pools = (array) ($data['default_pools'] ?? []);
        $dto->region_pools = (array) ($data['region_pools'] ?? []);
        $dto->pop_pools = (array) ($data['pop_pools'] ?? []);
        $dto->proxied = (bool) ($data['proxied'] ?? false);
        $dto->steering_policy = (string) ($data['steering_policy'] ?? '');

        return $dto;
    }
}
