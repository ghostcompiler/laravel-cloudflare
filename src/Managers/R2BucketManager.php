<?php

namespace Vendor\Cloudflare\Managers;

class R2BucketManager extends AbstractManager
{

    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/r2/buckets");
        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => \Vendor\Cloudflare\DTOs\R2Bucket::fromArray($item), $data["result"]["buckets"] ?? []);
            return new \Vendor\Cloudflare\Collections\R2BucketCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $name)
    {
        $response = $this->getRequest("accounts/{$accountId}/r2/buckets/{$name}");
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\R2Bucket::fromArray($data["result"] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/r2/buckets", $data);
        return $this->hydrate($response, function (array $data) {
            return \Vendor\Cloudflare\DTOs\R2Bucket::fromArray($data["result"] ?? []);
        });
    }

    public function delete(string $accountId, string $name)
    {
        return $this->deleteRequest("accounts/{$accountId}/r2/buckets/{$name}");
    }
}
