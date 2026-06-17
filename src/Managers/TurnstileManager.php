<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\TurnstileWidgetCollection;
use Vendor\Cloudflare\DTOs\TurnstileWidget;

class TurnstileManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/challenges/widgets", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => TurnstileWidget::fromArray($item), $data['result'] ?? []);

            return new TurnstileWidgetCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $sitekey)
    {
        $response = $this->getRequest("accounts/{$accountId}/challenges/widgets/{$sitekey}");

        return $this->hydrate($response, function (array $data) {
            return TurnstileWidget::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/challenges/widgets", $data);

        return $this->hydrate($response, function (array $data) {
            return TurnstileWidget::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $sitekey, array $data)
    {
        $response = $this->putRequest("accounts/{$accountId}/challenges/widgets/{$sitekey}", $data);

        return $this->hydrate($response, function (array $data) {
            return TurnstileWidget::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $sitekey)
    {
        return $this->deleteRequest("accounts/{$accountId}/challenges/widgets/{$sitekey}");
    }

    public function rotateSecret(string $accountId, string $sitekey)
    {
        $response = $this->postRequest("accounts/{$accountId}/challenges/widgets/{$sitekey}/rotate_secret");

        return $this->hydrate($response, function (array $data) {
            return TurnstileWidget::fromArray($data['result'] ?? []);
        });
    }
}
