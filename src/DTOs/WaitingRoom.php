<?php

namespace Vendor\Cloudflare\DTOs;

class WaitingRoom
{
    public string $id;

    public string $name;

    public string $description;

    public string $host;

    public string $path;

    public string $status;

    public int $total_active_users;

    public int $users_per_minute;

    public int $queueing_delay_seconds;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->description = (string) ($data['description'] ?? '');
        $dto->host = (string) ($data['host'] ?? '');
        $dto->path = (string) ($data['path'] ?? '');
        $dto->status = (string) ($data['status'] ?? '');
        $dto->total_active_users = (int) ($data['total_active_users'] ?? 0);
        $dto->users_per_minute = (int) ($data['users_per_minute'] ?? 0);
        $dto->queueing_delay_seconds = (int) ($data['queueing_delay_seconds'] ?? 0);

        return $dto;
    }
}
