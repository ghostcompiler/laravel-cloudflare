<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\LoadBalancerCollection;
use Vendor\Cloudflare\DTOs\LoadBalancer;

class LoadBalancerManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/load_balancers", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => LoadBalancer::fromArray($item), $data['result'] ?? []);

            return new LoadBalancerCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/load_balancers/{$id}");

        return $this->hydrate($response, function (array $data) {
            return LoadBalancer::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/load_balancers", $data);

        return $this->hydrate($response, function (array $data) {
            return LoadBalancer::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/load_balancers/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return LoadBalancer::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/load_balancers/{$id}");
    }
}
