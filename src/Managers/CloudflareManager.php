<?php

namespace Vendor\Cloudflare\Managers;

use GuzzleHttp\Promise\Utils;
use Vendor\Cloudflare\Http\Client\CloudflareClient;

class CloudflareManager
{
    private CloudflareClient $client;

    private array $managers = [];

    public function __construct(CloudflareClient $client)
    {
        $this->client = $client;
    }

    public function authenticate(string $tokenOrEmail, ?string $apiKey = null): self
    {
        $this->client->authenticate($tokenOrEmail, $apiKey);

        return $this;
    }

    public function client(): CloudflareClient
    {
        return $this->client;
    }

    public function version(): string
    {
        $path = __DIR__.'/../../composer.json';
        if (file_exists($path)) {
            $composer = json_decode(file_get_contents($path), true);

            return $composer['version'] ?? '1.0.0';
        }

        return '1.0.0';
    }

    public function config(): array
    {
        if (function_exists('config')) {
            return config('cloudflare') ?: [];
        }

        return [];
    }

    public function rateLimit(): array
    {
        return $this->client->getLastRateLimit();
    }

    public function ping(): bool
    {
        try {
            // Verify token / check user
            $this->user()->get();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function health(): array
    {
        $start = microtime(true);
        $ping = $this->ping();
        $latency = (int) ((microtime(true) - $start) * 1000);

        return [
            'status' => $ping ? 'healthy' : 'unhealthy',
            'latency_ms' => $latency,
            'timestamp' => time(),
        ];
    }

    /**
     * Run multiple SDK requests concurrently.
     */
    public function batch(array $callbacks): array
    {
        $this->client->startBatch();

        $callbackPromises = [];
        foreach ($callbacks as $callback) {
            $callbackPromises[] = $callback();
        }

        $this->client->endBatch();

        if (empty($callbackPromises)) {
            return [];
        }

        return Utils::all($callbackPromises)->wait();
    }

    public function accounts(): AccountManager
    {
        return $this->getManager(AccountManager::class);
    }

    public function zones(): ZoneManager
    {
        return $this->getManager(ZoneManager::class);
    }

    public function zoneSettings(): ZoneSettingManager
    {
        return $this->getManager(ZoneSettingManager::class);
    }

    public function dns(): DnsRecordManager
    {
        return $this->getManager(DnsRecordManager::class);
    }

    public function sslCertificates(): SslCertificateManager
    {
        return $this->getManager(SslCertificateManager::class);
    }

    public function certificatePacks(): CertificatePackManager
    {
        return $this->getManager(CertificatePackManager::class);
    }

    public function customHostnames(): CustomHostnameManager
    {
        return $this->getManager(CustomHostnameManager::class);
    }

    public function firewallRules(): FirewallRuleManager
    {
        return $this->getManager(FirewallRuleManager::class);
    }

    public function rulesets(): RulesetManager
    {
        return $this->getManager(RulesetManager::class);
    }

    public function pageRules(): PageRuleManager
    {
        return $this->getManager(PageRuleManager::class);
    }

    public function cache(): CacheManager
    {
        return $this->getManager(CacheManager::class);
    }

    public function loadBalancers(): LoadBalancerManager
    {
        return $this->getManager(LoadBalancerManager::class);
    }

    public function loadBalancerPools(): LoadBalancerPoolManager
    {
        return $this->getManager(LoadBalancerPoolManager::class);
    }

    public function loadBalancerMonitors(): LoadBalancerMonitorManager
    {
        return $this->getManager(LoadBalancerMonitorManager::class);
    }

    public function workers(): WorkerScriptManager
    {
        return $this->getManager(WorkerScriptManager::class);
    }

    public function workerRoutes(): WorkerRouteManager
    {
        return $this->getManager(WorkerRouteManager::class);
    }

    public function kv(): KvNamespaceManager
    {
        return $this->getManager(KvNamespaceManager::class);
    }

    public function r2(): R2BucketManager
    {
        return $this->getManager(R2BucketManager::class);
    }

    public function d1(): D1DatabaseManager
    {
        return $this->getManager(D1DatabaseManager::class);
    }

    public function pages(): PagesProjectManager
    {
        return $this->getManager(PagesProjectManager::class);
    }

    public function images(): ImageManager
    {
        return $this->getManager(ImageManager::class);
    }

    public function stream(): StreamManager
    {
        return $this->getManager(StreamManager::class);
    }

    public function emailRouting(): EmailRoutingManager
    {
        return $this->getManager(EmailRoutingManager::class);
    }

    public function access(): AccessApplicationManager
    {
        return $this->getManager(AccessApplicationManager::class);
    }

    public function tunnels(): TunnelManager
    {
        return $this->getManager(TunnelManager::class);
    }

    public function turnstile(): TurnstileManager
    {
        return $this->getManager(TurnstileManager::class);
    }

    public function healthchecks(): HealthcheckManager
    {
        return $this->getManager(HealthcheckManager::class);
    }

    public function waitingRooms(): WaitingRoomManager
    {
        return $this->getManager(WaitingRoomManager::class);
    }

    public function logpush(): LogpushManager
    {
        return $this->getManager(LogpushManager::class);
    }

    public function user(): UserManager
    {
        return $this->getManager(UserManager::class);
    }

    /**
     * Lazy instantiate and cache managers.
     */
    private function getManager(string $class)
    {
        if (! isset($this->managers[$class])) {
            $this->managers[$class] = new $class($this->client);
        }

        return $this->managers[$class];
    }
}
