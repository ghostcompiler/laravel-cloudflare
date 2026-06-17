<?php

namespace Vendor\Cloudflare\Managers;

class LoadBalancerPoolManager extends AbstractManager
{

    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/load_balancers/pools", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\LoadBalancerPool::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\LoadBalancerPoolCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/load_balancers/pools/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LoadBalancerPool::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/load_balancers/pools", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LoadBalancerPool::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $accountId, string $id, array $data)
    {
        $response = $this->putRequest("accounts/{$accountId}/load_balancers/pools/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LoadBalancerPool::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/load_balancers/pools/{$id}");
    }

    public function health(string $accountId, string $id)
    {
        return $this->getRequest("accounts/{$accountId}/load_balancers/pools/{$id}/health");
    }
}
