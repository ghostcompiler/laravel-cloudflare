<?php

namespace Vendor\Cloudflare\DTOs;

class DnsRecord
{
    public string $id;

    public string $zone_id;

    public string $zone_name;

    public string $name;

    public string $type;

    public string $content;

    public bool $proxiable;

    public bool $proxied;

    public int $ttl;

    public bool $locked;

    public string $created_on;

    public string $modified_on;

    public array $meta;

    public int $priority;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->zone_id = (string) ($data['zone_id'] ?? '');
        $dto->zone_name = (string) ($data['zone_name'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->type = (string) ($data['type'] ?? '');
        $dto->content = (string) ($data['content'] ?? '');
        $dto->proxiable = (bool) ($data['proxiable'] ?? false);
        $dto->proxied = (bool) ($data['proxied'] ?? false);
        $dto->ttl = (int) ($data['ttl'] ?? 0);
        $dto->locked = (bool) ($data['locked'] ?? false);
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->modified_on = (string) ($data['modified_on'] ?? '');
        $dto->meta = (array) ($data['meta'] ?? []);
        $dto->priority = (int) ($data['priority'] ?? 0);

        return $dto;
    }
}
