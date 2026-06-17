<?php

namespace Vendor\Cloudflare\DTOs;

class CustomHostname
{
    public string $id;

    public string $hostname;

    public array $ssl;

    public string $custom_origin_server;

    public array $custom_metadata;

    public string $status;

    public array $verification_errors;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->hostname = (string) ($data['hostname'] ?? '');
        $dto->ssl = (array) ($data['ssl'] ?? []);
        $dto->custom_origin_server = (string) ($data['custom_origin_server'] ?? '');
        $dto->custom_metadata = (array) ($data['custom_metadata'] ?? []);
        $dto->status = (string) ($data['status'] ?? '');
        $dto->verification_errors = (array) ($data['verification_errors'] ?? []);

        return $dto;
    }
}
