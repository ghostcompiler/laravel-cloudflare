<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\ZoneSettingCollection;
use Vendor\Cloudflare\DTOs\ZoneSetting;

class ZoneSettingManager extends AbstractManager
{
    public function all(string $zoneId)
    {
        $response = $this->getRequest("zones/{$zoneId}/settings");

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => ZoneSetting::fromArray($item), $data['result'] ?? []);

            return new ZoneSettingCollection($items);
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
            return ZoneSetting::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $zoneId, string $settingName, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/settings/{$settingName}", $data);

        return $this->hydrate($response, function (array $data) {
            return ZoneSetting::fromArray($data['result'] ?? []);
        });
    }

    public function updateMultiple(string $zoneId, array $data)
    {
        $response = $this->patchRequest("zones/{$zoneId}/settings", $data);

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => ZoneSetting::fromArray($item), $data['result'] ?? []);

            return new ZoneSettingCollection($items);
        });
    }
}
