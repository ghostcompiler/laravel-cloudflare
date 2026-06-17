<?php

namespace Vendor\Cloudflare\Managers;

class HealthcheckManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/healthchecks", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\Healthcheck::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\HealthcheckCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/healthchecks/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Healthcheck::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/healthchecks", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Healthcheck::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/healthchecks/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Healthcheck::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/healthchecks/{$id}");
    }
}
