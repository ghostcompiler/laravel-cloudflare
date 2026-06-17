<?php

namespace Vendor\Cloudflare\DTOs;

class SslCertificate
{
    public string $id;

    public string $type;

    public array $hosts;

    public string $status;

    public string $not_before;

    public string $not_after;

    public string $signature;

    public string $fingerprint;

    public string $uploaded_on;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->type = (string) ($data['type'] ?? '');
        $dto->hosts = (array) ($data['hosts'] ?? []);
        $dto->status = (string) ($data['status'] ?? '');
        $dto->not_before = (string) ($data['not_before'] ?? '');
        $dto->not_after = (string) ($data['not_after'] ?? '');
        $dto->signature = (string) ($data['signature'] ?? '');
        $dto->fingerprint = (string) ($data['fingerprint'] ?? '');
        $dto->uploaded_on = (string) ($data['uploaded_on'] ?? '');

        return $dto;
    }
}
