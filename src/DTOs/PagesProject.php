<?php

namespace Vendor\Cloudflare\DTOs;

class PagesProject
{
    public string $name;

    public string $subdomain;

    public array $domains;

    public array $source;

    public array $build_config;

    public array $deployment_configs;

    public string $created_on;

    public string $production_branch;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->name = (string) ($data['name'] ?? '');
        $dto->subdomain = (string) ($data['subdomain'] ?? '');
        $dto->domains = (array) ($data['domains'] ?? []);
        $dto->source = (array) ($data['source'] ?? []);
        $dto->build_config = (array) ($data['build_config'] ?? []);
        $dto->deployment_configs = (array) ($data['deployment_configs'] ?? []);
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->production_branch = (string) ($data['production_branch'] ?? '');

        return $dto;
    }
}
