<?php

namespace Vendor\Cloudflare\Managers;

class SslCertificateManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/custom_certificates", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\SslCertificate::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\SslCertificateCollection($items);
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
            return \Vendor\Cloudflare\DTOs\SslCertificate::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/custom_certificates", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\SslCertificate::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/custom_certificates/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\SslCertificate::fromArray($data["result"] ?? []);
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
