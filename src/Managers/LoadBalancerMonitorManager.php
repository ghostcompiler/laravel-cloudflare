<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\Collections\LoadBalancerMonitorCollection;
use Vendor\Cloudflare\DTOs\LoadBalancerMonitor;

class LoadBalancerMonitorManager extends AbstractManager
{
    public function all(string $accountId)
    {
        $response = $this->getRequest("accounts/{$accountId}/load_balancers/monitors", $this->buildQueryParams());

        return $this->hydrate($response, function (array $data) {
            $items = array_map(fn (array $item) => LoadBalancerMonitor::fromArray($item), $data['result'] ?? []);

            return new LoadBalancerMonitorCollection($items);
        });
    }

    public function get(string $accountId)
    {
        return $this->all($accountId);
    }

    public function find(string $accountId, string $id)
    {
        $response = $this->getRequest("accounts/{$accountId}/load_balancers/monitors/{$id}");

        return $this->hydrate($response, function (array $data) {
            return LoadBalancerMonitor::fromArray($data['result'] ?? []);
        });
    }

    public function create(string $accountId, array $data)
    {
        $response = $this->postRequest("accounts/{$accountId}/load_balancers/monitors", $data);

        return $this->hydrate($response, function (array $data) {
            return LoadBalancerMonitor::fromArray($data['result'] ?? []);
        });
    }

    public function update(string $accountId, string $id, array $data)
    {
        $response = $this->putRequest("accounts/{$accountId}/load_balancers/monitors/{$id}", $data);

        return $this->hydrate($response, function (array $data) {
            return LoadBalancerMonitor::fromArray($data['result'] ?? []);
        });
    }

    public function delete(string $accountId, string $id)
    {
        return $this->deleteRequest("accounts/{$accountId}/load_balancers/monitors/{$id}");
    }
}
