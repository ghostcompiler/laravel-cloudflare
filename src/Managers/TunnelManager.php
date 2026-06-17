<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\TunnelCollection;
use Vendor\Cloudflare\DTOs\Tunnel;

class TunnelManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/cfd_tunnel", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => Tunnel::fromArray($item), $data['result'] ?? []);

            return new TunnelCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/cfd_tunnel/{$id}");

        return $this->hydrate($response, function (array $data) {
            return Tunnel::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/cfd_tunnel", $data);

        return $this->hydrate($response, function (array $data) {
            return Tunnel::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $id, array $data)
    {
        $response = $this->patchRequest("accounts/{$accountId}/cfd_tunnel/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return Tunnel::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/cfd_tunnel/{$id}");
    }

    public function getToken(string $accountId, string $id)
    {
        return $this->getRequest("accounts/{$accountId}/cfd_tunnel/{$id}/token");
    }

    public function cleanConnections(string $accountId, string $id)
    {
        return $this->postRequest("accounts/{$accountId}/cfd_tunnel/{$id}/connections/clean");
    }
}
