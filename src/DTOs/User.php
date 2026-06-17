<?php

namespace Vendor\Cloudflare\DTOs;

class User
{
    public string $id;

    public string $email;

    public string $first_name;

    public string $last_name;

    public string $username;

    public string $telephone;

    public string $country;

    public string $zipcode;

    public bool $two_factor_authentication_enabled;

    public string $created_on;

    public string $modified_on;

    /**
     * Create a new DTO instance from array data.
     */
    public static function fromArray(array $data): self
    {
        $dto = new self;
        $dto->id = (string) ($data['id'] ?? '');
        $dto->email = (string) ($data['email'] ?? '');
        $dto->first_name = (string) ($data['first_name'] ?? '');
        $dto->last_name = (string) ($data['last_name'] ?? '');
        $dto->username = (string) ($data['username'] ?? '');
        $dto->telephone = (string) ($data['telephone'] ?? '');
        $dto->country = (string) ($data['country'] ?? '');
        $dto->zipcode = (string) ($data['zipcode'] ?? '');
        $dto->two_factor_authentication_enabled = (bool) ($data['two_factor_authentication_enabled'] ?? false);
        $dto->created_on = (string) ($data['created_on'] ?? '');
        $dto->modified_on = (string) ($data['modified_on'] ?? '');

        return $dto;
    }
}
