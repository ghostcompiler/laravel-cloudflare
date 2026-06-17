<?php

namespace Vendor\Cloudflare\DTOs;

class Zone
{
    public string $id;

    public string $name;

    public string $status;

    public bool $paused;

    public string $type;

    public int $development_mode;

    public array $name_servers;

    public array $original_name_servers;

    public string $modified_on;

    public string $created_on;

    public array $meta;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->status = (string) ($data['status'] ?? '');
        $dto->paused = (bool) ($data['paused'] ?? false);
        $dto->type = (string) ($data['type'] ?? '');
        $dto->development_mode = (int) ($data['development_mode'] ?? 0);
        $dto->name_servers = (array) ($data['name_servers'] ?? []);
        $dto->original_name_servers = (array) ($data['original_name_servers'] ?? []);
        $dto->modified_on = (string) ($data['modified_on'] ?? '');
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->meta = (array) ($data['meta'] ?? []);

        return $dto;
    }
}
