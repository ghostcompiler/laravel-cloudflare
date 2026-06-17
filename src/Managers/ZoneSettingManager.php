<?php

namespace Vendor\Cloudflare\Managers;

class ZoneSettingManager extends AbstractManager
{

    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/settings");
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\ZoneSetting::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\ZoneSettingCollection($items);
        });
    }

    public function get(string $zoneId)
    {
        return $this->all($zoneId);
    }

    public function find(string $zoneId, string $settingName)
    {
        $response = $this->getRequest("zones/{$zoneId}/settings/{$settingName}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\ZoneSetting::fromArray($data["result"] ?? []);
        });
    }

    public function update(string $zoneId, string $settingName, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/settings/{$settingName}", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\ZoneSetting::fromArray($data["result"] ?? []);
        });
    }

    public function updateMultiple(string $zoneId, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/settings", $data);
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\ZoneSetting::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\ZoneSettingCollection($items);
        });
    }
}
