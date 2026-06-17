<?php

namespace Vendor\Cloudflare\Managers;

class CacheManager extends AbstractManager
{

    public function purgeAll(string $zoneId)
    {
        return $this->postRequest("zones/{$zoneId}/purge_cache", ["purge_everything" => true]);
    }

    public function purgeFiles(string $zoneId, array $files)
    {
        return $this->postRequest("zones/{$zoneId}/purge_cache", ["files" => $files]);
    }

    public function purgeTags(string $zoneId, array $tags)
    {
        return $this->postRequest("zones/{$zoneId}/purge_cache", ["tags" => $tags]);
    }

    public function purgeHosts(string $zoneId, array $hosts)
    {
        return $this->postRequest("zones/{$zoneId}/purge_cache", ["hosts" => $hosts]);
    }

    public function purgePrefixes(string $zoneId, array $prefixes)
    {
        return $this->postRequest("zones/{$zoneId}/purge_cache", ["prefixes" => $prefixes]);
    }
}
