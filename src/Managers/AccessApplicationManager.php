<?php

namespace Vendor\Cloudflare\Managers;

class AccessApplicationManager extends AbstractManager
{

    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/access/apps", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\AccessApplication::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\AccessApplicationCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/access/apps/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\AccessApplication::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/access/apps", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\AccessApplication::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $accountId, string $id, array $data)
    {
        $response = $this->putRequest("accounts/{$accountId}/access/apps/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\AccessApplication::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/access/apps/{$id}");
    }

    public function policies(string $accountId, string $appId)
    {
        return $this->getRequest("accounts/{$accountId}/access/apps/{$appId}/policies");
    }
}
