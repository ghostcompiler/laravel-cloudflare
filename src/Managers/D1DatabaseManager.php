<?php

namespace Vendor\Cloudflare\Managers;

class D1DatabaseManager extends AbstractManager
{

    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/d1/database", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\D1Database::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\D1DatabaseCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/d1/database/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\D1Database::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/d1/database", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\D1Database::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/d1/database/{$id}");
    }

    public function query(string $accountId, string $id, string $sql, array $params = [])
    {
        return $this->postRequest("accounts/{$accountId}/d1/database/{$id}/query", ["sql" => $sql, "params" => $params]);
    }

    public function raw(string $accountId, string $id, string $sql, array $params = [])
    {
        return $this->postRequest("accounts/{$accountId}/d1/database/{$id}/raw", ["sql" => $sql, "params" => $params]);
    }
}
