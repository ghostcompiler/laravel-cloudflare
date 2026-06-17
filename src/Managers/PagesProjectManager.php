<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\PagesProjectCollection;
use Vendor\Cloudflare\DTOs\PagesProject;

class PagesProjectManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/pages/projects");

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => PagesProject::fromArray($item), $data['result'] ?? []);

            return new PagesProjectCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $name)
    {
        $response = $this->getRequest("accounts/{$accountId}/pages/projects/{$name}");

        return $this->hydrate($response, function (array $data) {
            return PagesProject::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/pages/projects", $data);

        return $this->hydrate($response, function (array $data) {
            return PagesProject::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $name, array $data)
    {
        $response = $this->patchRequest("accounts/{$accountId}/pages/projects/{$name}", $data);

        return $this->hydrate($response, function (array $data) {
            return PagesProject::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $name)
    {
        return $this->deleteRequest("accounts/{$accountId}/pages/projects/{$name}");
    }

    public function deployments(string $accountId, string $projectName)
    {
        return $this->getRequest("accounts/{$accountId}/pages/projects/{$projectName}/deployments");
    }
}
