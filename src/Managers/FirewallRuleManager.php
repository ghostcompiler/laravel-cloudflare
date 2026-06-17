<?php

namespace Vendor\Cloudflare\Managers;

class FirewallRuleManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/firewall/rules", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\FirewallRule::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\FirewallRuleCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function paginate(string $zoneId, int $perPage = 25, int $page = 1)
    {
        $this->perPage($perPage)->page($page);
        $response = $this->getRequest("zones/{$zoneId}/firewall/rules", $this->buildQueryParams());
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\FirewallRule::fromArray($item), $data["result"] ?? []);
            $meta = \Vendor\Cloudflare\DTOs\PaginationMeta::fromArray(array_merge($data["result_info"] ?? [], [
                "per_page" => $this->perPage ?? 25,
                "page" => $this->page ?? 1,
                "total_entries" => $data["result_info"]["total_count"] ?? count($items),
                "last_page" => isset($data["result_info"]["total_count"]) ? (int)ceil($data["result_info"]["total_count"] / ($this->perPage ?? 25)) : 1
            ]));
            return new \Vendor\Cloudflare\Responses\PaginatedResponse(new \Vendor\Cloudflare\Collections\FirewallRuleCollection($items), $meta);
        });
    }

    public function find(string $zoneId, string $id)
    {
        $response = $this->getRequest("zones/{$zoneId}/firewall/rules/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\FirewallRule::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneId, array $data)
    {
        $response = $this->postRequest("zones/{$zoneId}/firewall/rules", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\FirewallRule::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $id, array $data)
    {
        $response = $this->putRequest("zones/{$zoneId}/firewall/rules/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\FirewallRule::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneId, string $id)
    {
        return $this->deleteRequest("zones/{$zoneId}/firewall/rules/{$id}");
    }
}
