<?php

namespace Vendor\Cloudflare\Managers;

class WaitingRoomManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/waiting_rooms", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\WaitingRoom::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\WaitingRoomCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/waiting_rooms/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\WaitingRoom::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/waiting_rooms", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\WaitingRoom::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/waiting_rooms/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\WaitingRoom::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/waiting_rooms/{$id}");
    }

    public function status(string $zoneId, string $id)
    {
        return $this->getRequest("zones/{$zoneId}/waiting_rooms/{$id}/status");
    }
}
