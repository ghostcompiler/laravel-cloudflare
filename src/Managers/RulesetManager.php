<?php

namespace Vendor\Cloudflare\Managers;

class RulesetManager extends AbstractManager
{

    public function all(string $zoneOrAccountId, bool $isAccount = false)
    {
        $prefix = $isAccount ? "accounts" : "zones";
        $response = $this->getRequest("{$prefix}/{$zoneOrAccountId}/rulesets");
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\Ruleset::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\RulesetCollection($items);
        });
    }

    public function get(string $zoneOrAccountId, bool $isAccount = false)
    {
        return $this->all($zoneOrAccountId, $isAccount);
    }

    public function find(string $zoneOrAccountId, string $id, bool $isAccount = false)
    {
        $prefix = $isAccount ? "accounts" : "zones";
        $response = $this->getRequest("{$prefix}/{$zoneOrAccountId}/rulesets/{$id}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Ruleset::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $zoneOrAccountId, array $data, bool $isAccount = false)
    {
        $prefix = $isAccount ? "accounts" : "zones";
        $response = $this->postRequest("{$prefix}/{$zoneOrAccountId}/rulesets", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Ruleset::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneOrAccountId, string $id, array $data, bool $isAccount = false)
    {
        $prefix = $isAccount ? "accounts" : "zones";
        $response = $this->patchRequest("{$prefix}/{$zoneOrAccountId}/rulesets/{$id}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\Ruleset::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $zoneOrAccountId, string $id, bool $isAccount = false)
    {
        $prefix = $isAccount ? "accounts" : "zones";
        return $this->deleteRequest("{$prefix}/{$zoneOrAccountId}/rulesets/{$id}");
    }
}
