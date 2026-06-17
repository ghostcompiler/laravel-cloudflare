<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\KvNamespaceCollection;
use Vendor\Cloudflare\DTOs\KvNamespace;
use Vendor\Cloudflare\DTOs\PaginationMeta;
use Vendor\Cloudflare\Responses\PaginatedResponse;

class KvNamespaceManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/storage/kv/namespaces", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => KvNamespace::fromArray($item), $data['result'] ?? []);

            return new KvNamespaceCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function paginate(string $accountId, int $perPage = 25, int $page = 1)
    {
        $this->perPage($perPage)->page($page);
        $response = $this->getRequest("accounts/{$accountId}/storage/kv/namespaces", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => KvNamespace::fromArray($item), $data['result'] ?? []);
            $meta = PaginationMeta::fromArray(array_merge($data['result_info'] ?? [], [
                'per_page' => $this->perPage ?? 25,
                'page' => $this->page ?? 1,
                'total_entries' => $data['result_info']['total_count'] ?? count($items),
                'last_page' => isset($data['result_info']['total_count']) ? (int) ceil($data['result_info']['total_count'] / ($this->perPage ?? 25)) : 1,
            ]));

            return new PaginatedResponse(new KvNamespaceCollection($items), $meta);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/storage/kv/namespaces", $data);

        return $this->hydrate($response, function (array $data) {
            return KvNamespace::fromArray($data['result'] ?? []);
        });
    }

    public function rename(string $accountId, string $id, string $title)
    {
        $response = $this->putRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}", ['title' => $title]);

        return $this->hydrate($response, function (array $data) {
            return KvNamespace::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}");
    }

    public function keys(string $accountId, string $id)
    {
        return $this->getRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}/keys");
    }

    public function getValue(string $accountId, string $id, string $key)
    {
        return $this->client->request('GET', "accounts/{$accountId}/storage/kv/namespaces/{$id}/values/{$key}");
    }

    public function putValue(string $accountId, string $id, string $key, string $value)
    {
        return $this->client->request('PUT', "accounts/{$accountId}/storage/kv/namespaces/{$id}/values/{$key}", ['body' => $value]);
    }

    public function deleteKey(string $accountId, string $id, string $key)
    {
        return $this->deleteRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}/values/{$key}");
    }

    public function bulkWrite(string $accountId, string $id, array $keyValues)
    {
        return $this->postRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}/bulk", $keyValues);
    }

    public function bulkDelete(string $accountId, string $id, array $keys)
    {
        return $this->deleteRequest("accounts/{$accountId}/storage/kv/namespaces/{$id}/bulk", $keys);
    }
}
