<?php

namespace Vendor\Cloudflare\DTOs;

class LoadBalancerMonitor
{
    public string $id;

    public string $type;

    public string $description;

    public string $path;

    public string $method;

    public int $port;

    public int $timeout;

    public int $retries;

    public int $interval;

    public string $expected_body;

    public string $expected_codes;

    public array $headers;

    public bool $allow_insecure;

    public bool $follow_redirects;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->type = (string) ($data['type'] ?? '');
        $dto->description = (string) ($data['description'] ?? '');
        $dto->path = (string) ($data['path'] ?? '');
        $dto->method = (string) ($data['method'] ?? '');
        $dto->port = (int) ($data['port'] ?? 0);
        $dto->timeout = (int) ($data['timeout'] ?? 0);
        $dto->retries = (int) ($data['retries'] ?? 0);
        $dto->interval = (int) ($data['interval'] ?? 0);
        $dto->expected_body = (string) ($data['expected_body'] ?? '');
        $dto->expected_codes = (string) ($data['expected_codes'] ?? '');
        $dto->headers = (array) ($data['headers'] ?? []);
        $dto->allow_insecure = (bool) ($data['allow_insecure'] ?? false);
        $dto->follow_redirects = (bool) ($data['follow_redirects'] ?? false);

        return $dto;
    }
}
