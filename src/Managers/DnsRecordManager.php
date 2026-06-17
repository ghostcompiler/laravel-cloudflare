<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\DnsRecordCollection;
use Vendor\Cloudflare\DTOs\DnsRecord;
use Vendor\Cloudflare\DTOs\PaginationMeta;
use Vendor\Cloudflare\Responses\PaginatedResponse;

class DnsRecordManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/dns_records", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => DnsRecord::fromArray($item), $data['result'] ?? []);

            return new DnsRecordCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function paginate(string $zoneId, int $perPage = 25, int $page = 1)
    {
        $this->perPage($perPage)->page($page);
        $response = $this->getRequest("zones/{$zoneId}/dns_records", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => DnsRecord::fromArray($item), $data['result'] ?? []);
            $meta = PaginationMeta::fromArray(array_merge($data['result_info'] ?? [], [
                'per_page' => $this->perPage ?? 25,
                'page' => $this->page ?? 1,
                'total_entries' => $data['result_info']['total_count'] ?? count($items),
                'last_page' => isset($data['result_info']['total_count']) ? (int) ceil($data['result_info']['total_count'] / ($this->perPage ?? 25)) : 1,
            ]));

            return new PaginatedResponse(new DnsRecordCollection($items), $meta);
        });
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/dns_records/{$id}");

        return $this->hydrate($response, function (array $data) {
            return DnsRecord::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/dns_records", $data);

        return $this->hydrate($response, function (array $data) {
            return DnsRecord::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/dns_records/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return DnsRecord::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/dns_records/{$id}");
    }

    public function import(string $zoneId, string $fileContent)
    {
        return $this->client->request('POST', "zones/{$zoneId}/dns_records/import", [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $fileContent,
                    'filename' => 'bind.txt',
                ],
            ],
        ]);
    }

    public function export(string $zoneId)
    {
        return $this->client->request('GET', "zones/{$zoneId}/dns_records/export");
    }

    public function scan(string $zoneId)
    {
        return $this->postRequest("zones/{$zoneId}/dns_records/scan");
    }
}
