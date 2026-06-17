<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\EmailRoutingRuleCollection;
use Vendor\Cloudflare\DTOs\EmailRoutingRule;

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
            $items = array_map(fn (array $item) => EmailRoutingRule::fromArray($item), $data['result'] ?? []);

            return new EmailRoutingRuleCollection($items);
        });
    }

    public function catchAll(string $zoneId)
    {
        return $this->getRequest("zones/{$zoneId}/email/routing/catch_all");
    }
}
