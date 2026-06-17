<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\CertificatePackCollection;
use Vendor\Cloudflare\DTOs\CertificatePack;

class CertificatePackManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/ssl/certificate_packs", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => CertificatePack::fromArray($item), $data['result'] ?? []);

            return new CertificatePackCollection($items);
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
            return CertificatePack::fromArray($data['result'] ?? []);
        });
    }

    public function order(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/ssl/certificate_packs", $data);

        return $this->hydrate($response, function (array $data) {
            return CertificatePack::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/ssl/certificate_packs/{$id}");
    }
}
