<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\ImageCollection;
use Vendor\Cloudflare\DTOs\Image;

class ImageManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/images/v1", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => Image::fromArray($item), $data['result']['images'] ?? []);

            return new ImageCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/images/v1/{$id}");

        return $this->hydrate($response, function (array $data) {
            return Image::fromArray($data['result'] ?? []);
        });
    }

    public function upload(string $accountId, string $fileContent, array $metadata = [])
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $fileContent,
                    'filename' => 'image.jpg',
                ],
            ],
        ];
        if (! empty($metadata)) {
            $options['multipart'][] = [
                'name' => 'metadata',
                'contents' => json_encode($metadata),
            ];
        }
        $response = $this->client->request('POST', "accounts/{$accountId}/images/v1", $options);

        return $this->hydrate($response, function (array $data) {
            return Image::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $id, array $data)
    {
        $response = $this->patchRequest("accounts/{$accountId}/images/v1/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return Image::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/images/v1/{$id}");
    }

    public function directUpload(string $accountId)
    {
        return $this->postRequest("accounts/{$accountId}/images/v1/direct_upload");
    }

    public function stats(string $accountId)
    {
        return $this->getRequest("accounts/{$accountId}/images/v1/stats");
    }
}
