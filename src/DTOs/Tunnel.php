<?php

namespace Vendor\Cloudflare\DTOs;

class Tunnel
{
    public string $id;

    public string $name;

    public string $status;

    public array $connections;

    public string $conns_active_at;

    public string $created_at;

    public string $deleted_at;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->status = (string) ($data['status'] ?? '');
        $dto->connections = (array) ($data['connections'] ?? []);
        $dto->conns_active_at = (string) ($data['conns_active_at'] ?? '');
        $dto->created_at = (string) ($data['created_at'] ?? '');
        $dto->deleted_at = (string) ($data['deleted_at'] ?? '');

        return $dto;
    }
}
