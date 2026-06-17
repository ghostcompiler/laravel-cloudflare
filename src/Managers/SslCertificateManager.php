<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\SslCertificateCollection;
use Vendor\Cloudflare\DTOs\SslCertificate;

class SslCertificateManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/custom_certificates", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => SslCertificate::fromArray($item), $data['result'] ?? []);

            return new SslCertificateCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/custom_certificates/{$id}");

        return $this->hydrate($response, function (array $data) {
            return SslCertificate::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/custom_certificates", $data);

        return $this->hydrate($response, function (array $data) {
            return SslCertificate::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/custom_certificates/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return SslCertificate::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/custom_certificates/{$id}");
    }

    public function reprioritize(string $zoneId, array $data)
    {
        return $this->putRequest("zones/{$zoneId}/custom_certificates/prioritize", $data);
    }
}
