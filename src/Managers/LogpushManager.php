<?php

namespace Vendor\Cloudflare\Managers;

class LogpushManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/logpush/jobs", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\LogpushJob::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\LogpushJobCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/logpush/jobs/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LogpushJob::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/logpush/jobs", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LogpushJob::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/logpush/jobs/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\LogpushJob::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/logpush/jobs/{$id}");
    }

    public function validateOwnership(string $zoneId, array $data)
    {
        return $this->postRequest("zones/{$zoneId}/logpush/ownership", $data);
    }
}
