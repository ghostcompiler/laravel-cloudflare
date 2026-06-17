<?php

namespace Vendor\Cloudflare\Managers;

class ZoneManager extends AbstractManager
{

    public function all()
    {
        $response = $this->getRequest("zones", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\Zone::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\ZoneCollection($items);
        });
    }

    public function get()
    {
        return $this->all();
    }

    public function paginate(int $perPage = 25, int $page = 1)
    {
        $this->perPage($perPage)->page($page);
        $response = $this->getRequest("zones", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\Zone::fromArray($item), $data["result"] ?? []);
            $meta = \Vendor\Cloudflare\DTOs\PaginationMeta::fromArray(array_merge($data["result_info"] ?? [], [
                "per_page" => $this->perPage ?? 25,
                "page" => $this->page ?? 1,
                "total_entries" => $data["result_info"]["total_count"] ?? count($items),
                "last_page" => isset($data["result_info"]["total_count"]) ? (int)ceil($data["result_info"]["total_count"] / ($this->perPage ?? 25)) : 1
            ]));
            return new \Vendor\Cloudflare\Responses\PaginatedResponse(new \Vendor\Cloudflare\Collections\ZoneCollection($items), $meta);
        });
    }

    public function find(string $id)
    {
        $response = $this->getRequest("zones/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Zone::fromArray($data["result"] ?? []);
        });
    }

    public function create(array $data)
    {
        $response = $this->postRequest("zones", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Zone::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $id, array $data)
    {
        $response = $this->patchRequest("zones/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Zone::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $id)
    {
        return $this->deleteRequest("zones/{$id}");
    }

    public function activationCheck(string $id)
    {
        return $this->postRequest("zones/{$id}/activation_check");
    }

    public function purgeCache(string $id, array $data)
    {
        return $this->postRequest("zones/{$id}/purge_cache", $data);
    }
}
