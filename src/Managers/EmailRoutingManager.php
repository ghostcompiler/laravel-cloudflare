<?php

namespace Vendor\Cloudflare\Managers;

class EmailRoutingManager extends AbstractManager
{

    public function getSettings(string $zoneId)
    {
        return $this->getRequest("zones/{$zoneId}/email/routing");
    }

    public function enable(string $zoneId)
    {
        return $this->postRequest("zones/{$zoneId}/email/routing/enable");
    }

    public function disable(string $zoneId)
    {
        return $this->postRequest("zones/{$zoneId}/email/routing/disable");
    }

    public function rules(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/email/routing/rules");
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\EmailRoutingRule::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\EmailRoutingRuleCollection($items);
        });
    }

    public function catchAll(string $zoneId)
    {
        return $this->getRequest("zones/{$zoneId}/email/routing/catch_all");
    }
}
