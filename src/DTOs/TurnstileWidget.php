<?php

namespace Vendor\Cloudflare\DTOs;

class TurnstileWidget
{
    public string $sitekey;

    public string $name;

    public array $domains;

    public string $mode;

    public string $secret;

    public string $created_on;

    public string $modified_on;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->sitekey = (string) ($data['sitekey'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->domains = (array) ($data['domains'] ?? []);
        $dto->mode = (string) ($data['mode'] ?? '');
        $dto->secret = (string) ($data['secret'] ?? '');
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->modified_on = (string) ($data['modified_on'] ?? '');

        return $dto;
    }
}
