<?php

namespace Vendor\Cloudflare\DTOs;

class StreamVideo
{
    public string $uid;

    public string $thumbnail;

    public bool $readyToStream;

    public array $status;

    public array $meta;

    public string $created;

    public string $modified;

    public int $size;

    public float $duration;

    public int $maxDurationSeconds;

    public string $preview;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->uid = (string) ($data['uid'] ?? '');
        $dto->thumbnail = (string) ($data['thumbnail'] ?? '');
        $dto->readyToStream = (bool) ($data['ready_to_stream'] ?? false);
        $dto->status = (array) ($data['status'] ?? []);
        $dto->meta = (array) ($data['meta'] ?? []);
        $dto->created = (string) ($data['created'] ?? '');
        $dto->modified = (string) ($data['modified'] ?? '');
        $dto->size = (int) ($data['size'] ?? 0);
        $dto->duration = (float) ($data['duration'] ?? 0.0);
        $dto->maxDurationSeconds = (int) ($data['max_duration_seconds'] ?? 0);
        $dto->preview = (string) ($data['preview'] ?? '');

        return $dto;
    }
}
