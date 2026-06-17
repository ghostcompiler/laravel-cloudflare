<?php

namespace Vendor\Cloudflare\DTOs;

class CertificatePack
{
    public string $id;

    public string $type;

    public array $hosts;

    public array $certificates;

    public string $primary_certificate;

    public string $status;

    public int $validity_days;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->type = (string) ($data['type'] ?? '');
        $dto->hosts = (array) ($data['hosts'] ?? []);
        $dto->certificates = (array) ($data['certificates'] ?? []);
        $dto->primary_certificate = (string) ($data['primary_certificate'] ?? '');
        $dto->status = (string) ($data['status'] ?? '');
        $dto->validity_days = (int) ($data['validity_days'] ?? 0);

        return $dto;
    }
}
