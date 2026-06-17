<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\WorkerRouteCollection;
use Vendor\Cloudflare\DTOs\WorkerRoute;

class WorkerRouteManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/workers/routes", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => WorkerRoute::fromArray($item), $data['result'] ?? []);

            return new WorkerRouteCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/workers/routes/{$id}");

        return $this->hydrate($response, function (array $data) {
            return WorkerRoute::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/workers/routes", $data);

        return $this->hydrate($response, function (array $data) {
            return WorkerRoute::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/workers/routes/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return WorkerRoute::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/workers/routes/{$id}");
    }
}
