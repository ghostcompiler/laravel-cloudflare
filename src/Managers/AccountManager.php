<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\AccountCollection;
use Vendor\Cloudflare\DTOs\Account;
use Vendor\Cloudflare\DTOs\PaginationMeta;
use Vendor\Cloudflare\Responses\PaginatedResponse;

class AccountManager extends AbstractManager
{
    public function all()
    {
        $response = $this->getRequest('accounts', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => Account::fromArray($item), $data['result'] ?? []);

            return new AccountCollection($items);
        });
    }

    public function get()
    {
        return $this->all();
    }

    public function paginate(int $perPage = 25, int $page = 1)
    {
        $this->perPage($perPage)->page($page);
        $response = $this->getRequest('accounts', $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => Account::fromArray($item), $data['result'] ?? []);
            $meta = PaginationMeta::fromArray(array_merge($data['result_info'] ?? [], [
                'per_page' => $this->perPage ?? 25,
                'page' => $this->page ?? 1,
                'total_entries' => $data['result_info']['total_count'] ?? count($items),
                'last_page' => isset($data['result_info']['total_count']) ? (int) ceil($data['result_info']['total_count'] / ($this->perPage ?? 25)) : 1,
            ]));

            return new PaginatedResponse(new AccountCollection($items), $meta);
        });
    }

    public function find(string $id)
    {
        $response = $this->getRequest("accounts/{$id}");

        return $this->hydrate($response, function (array $data) {
            return Account::fromArray($data['result'] ?? []);
        });
    }

    public function create(array $data)
    {
        $response = $this->postRequest('accounts', $data);

        return $this->hydrate($response, function (array $data) {
            return Account::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $id, array $data)
    {
        $response = $this->putRequest("accounts/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return Account::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $id)
    {
        return $this->deleteRequest("accounts/{$id}");
    }

    public function members(string $id)
    {
        return $this->getRequest("accounts/{$id}/members");
    }

    public function roles(string $id)
    {
        return $this->getRequest("accounts/{$id}/roles");
    }
}
