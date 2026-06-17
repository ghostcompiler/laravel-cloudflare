<?php

namespace Vendor\Cloudflare\Managers;

class CertificatePackManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/ssl/certificate_packs", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\CertificatePack::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\CertificatePackCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/ssl/certificate_packs/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\CertificatePack::fromArray($data["result"] ?? []);
        });
    }

    public function order(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/ssl/certificate_packs", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\CertificatePack::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/ssl/certificate_packs/{$id}");
    }
}
