<?php

namespace Vendor\Cloudflare\Managers;

class WorkerScriptManager extends AbstractManager
{

    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/workers/scripts");
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\WorkerScript::fromArray($item), $data["result"] ?? []);
            return new \Vendor\Cloudflare\Collections\WorkerScriptCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $name)
    {
        $response = $this->getRequest("accounts/{$accountId}/workers/scripts/{$name}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\WorkerScript::fromArray($data["result"] ?? []);
        });
    }

    public function upload(string $accountId, string $name, string $scriptContent, array $metadata = [])
    {
        $options = [
            "headers" => ["Content-Type" => "application/javascript"],
            "body" => $scriptContent
        ];
        if (!empty($metadata)) {
            $options = [
                "multipart" => [
                    [
                        "name" => "metadata",
                        "contents" => json_encode($metadata),
                        "headers" => ["Content-Type" => "application/json"]
                    ],
                    [
                        "name" => "script",
                        "contents" => $scriptContent,
                        "headers" => ["Content-Type" => "application/javascript"]
                    ]
                ]
            ];
        }
        $response = $this->client->request("PUT", "accounts/{$accountId}/workers/scripts/{$name}", $options);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\WorkerScript::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $accountId, string $name)
    {
        return $this->deleteRequest("accounts/{$accountId}/workers/scripts/{$name}");
    }

    public function getSettings(string $accountId, string $name)
    {
        return $this->getRequest("accounts/{$accountId}/workers/scripts/{$name}/settings");
    }

    public function updateSettings(string $accountId, string $name, array $settings)
    {
        return $this->patchRequest("accounts/{$accountId}/workers/scripts/{$name}/settings", $settings);
    }
}
