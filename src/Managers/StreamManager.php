<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\StreamVideoCollection;
use Vendor\Cloudflare\DTOs\StreamVideo;

class StreamManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/stream", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => StreamVideo::fromArray($item), $data['result'] ?? []);

            return new StreamVideoCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $uid)
    {
        $response = $this->getRequest("accounts/{$accountId}/stream/{$uid}");

        return $this->hydrate($response, function (array $data) {
            return StreamVideo::fromArray($data['result'] ?? []);
        });
    }

    public function upload(string $accountId, string $fileContent)
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $fileContent,
                    'filename' => 'video.mp4',
                ],
            ],
        ];
        $response = $this->client->request('POST', "accounts/{$accountId}/stream", $options);

        return $this->hydrate($response, function (array $data) {
            return StreamVideo::fromArray($data['result'] ?? []);
        });
    }

    public function copy(string $accountId, string $url)
    {
        $response = $this->postRequest("accounts/{$accountId}/stream/copy", ['url' => $url]);

        return $this->hydrate($response, function (array $data) {
            return StreamVideo::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $uid, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/stream/{$uid}", $data);

        return $this->hydrate($response, function (array $data) {
            return StreamVideo::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $uid)
    {
        return $this->deleteRequest("accounts/{$accountId}/stream/{$uid}");
    }

    public function embed(string $accountId, string $uid)
    {
        return $this->getRequest("accounts/{$accountId}/stream/{$uid}/embed");
    }

    public function token(string $accountId, string $uid)
    {
        return $this->postRequest("accounts/{$accountId}/stream/{$uid}/token");
    }
}
