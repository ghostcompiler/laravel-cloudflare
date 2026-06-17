<?php

namespace Vendor\Cloudflare\DTOs;

class Healthcheck
{
    public string $id;

    public string $name;

    public string $description;

    public string $address;

    public bool $suspended;

    public array $check_regions;

    public string $type;

    public int $port;

    public string $method;

    public string $path;

    public string $expected_body;

    public array $expected_codes;

    public bool $follow_redirects;

    public bool $allow_insecure;

    public int $timeout;

    public int $retries;

    public int $interval;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->name = (string) ($data['name'] ?? '');
        $dto->description = (string) ($data['description'] ?? '');
        $dto->address = (string) ($data['address'] ?? '');
        $dto->suspended = (bool) ($data['suspended'] ?? false);
        $dto->check_regions = (array) ($data['check_regions'] ?? []);
        $dto->type = (string) ($data['type'] ?? '');
        $dto->port = (int) ($data['port'] ?? 0);
        $dto->method = (string) ($data['method'] ?? '');
        $dto->path = (string) ($data['path'] ?? '');
        $dto->expected_body = (string) ($data['expected_body'] ?? '');
        $dto->expected_codes = (array) ($data['expected_codes'] ?? []);
        $dto->follow_redirects = (bool) ($data['follow_redirects'] ?? false);
        $dto->allow_insecure = (bool) ($data['allow_insecure'] ?? false);
        $dto->timeout = (int) ($data['timeout'] ?? 0);
        $dto->retries = (int) ($data['retries'] ?? 0);
        $dto->interval = (int) ($data['interval'] ?? 0);

        return $dto;
    }
}
