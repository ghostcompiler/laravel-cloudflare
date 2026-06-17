<?php

namespace Vendor\Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;
use Vendor\Cloudflare\Managers\CloudflareManager;

/**
 * @method static \Vendor\Cloudflare\Managers\CloudflareManager authenticate(string $tokenOrEmail, ?string $apiKey = null)
 * @method static \Vendor\Cloudflare\Managers\AccountManager accounts()
 * @method static \Vendor\Cloudflare\Managers\ZoneManager zones()
 * @method static \Vendor\Cloudflare\Managers\ZoneSettingManager zoneSettings()
 * @method static \Vendor\Cloudflare\Managers\DnsRecordManager dns()
 * @method static \Vendor\Cloudflare\Managers\SslCertificateManager sslCertificates()
 * @method static \Vendor\Cloudflare\Managers\CertificatePackManager certificatePacks()
 * @method static \Vendor\Cloudflare\Managers\CustomHostnameManager customHostnames()
 * @method static \Vendor\Cloudflare\Managers\FirewallRuleManager firewallRules()
 * @method static \Vendor\Cloudflare\Managers\RulesetManager rulesets()
 * @method static \Vendor\Cloudflare\Managers\PageRuleManager pageRules()
 * @method static \Vendor\Cloudflare\Managers\CacheManager cache()
 * @method static \Vendor\Cloudflare\Managers\LoadBalancerManager loadBalancers()
 * @method static \Vendor\Cloudflare\Managers\LoadBalancerPoolManager loadBalancerPools()
 * @method static \Vendor\Cloudflare\Managers\LoadBalancerMonitorManager loadBalancerMonitors()
 * @method static \Vendor\Cloudflare\Managers\WorkerScriptManager workers()
 * @method static \Vendor\Cloudflare\Managers\WorkerRouteManager workerRoutes()
 * @method static \Vendor\Cloudflare\Managers\KvNamespaceManager kv()
 * @method static \Vendor\Cloudflare\Managers\R2BucketManager r2()
 * @method static \Vendor\Cloudflare\Managers\D1DatabaseManager d1()
 * @method static \Vendor\Cloudflare\Managers\PagesProjectManager pages()
 * @method static \Vendor\Cloudflare\Managers\ImageManager images()
 * @method static \Vendor\Cloudflare\Managers\StreamManager stream()
 * @method static \Vendor\Cloudflare\Managers\EmailRoutingManager emailRouting()
 * @method static \Vendor\Cloudflare\Managers\AccessApplicationManager access()
 * @method static \Vendor\Cloudflare\Managers\TunnelManager tunnels()
 * @method static \Vendor\Cloudflare\Managers\TurnstileManager turnstile()
 * @method static \Vendor\Cloudflare\Managers\HealthcheckManager healthchecks()
 * @method static \Vendor\Cloudflare\Managers\WaitingRoomManager waitingRooms()
 * @method static \Vendor\Cloudflare\Managers\LogpushManager logpush()
 * @method static \Vendor\Cloudflare\Managers\UserManager user()
 * @method static bool ping()
 * @method static string version()
 * @method static array rateLimit()
 * @method static array health()
 * @method static array config()
 * @method static \Vendor\Cloudflare\Http\Client\CloudflareClient client()
 * @method static array batch(array $callbacks)
 *
 * @see CloudflareManager
 */
class Cloudflare extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cloudflare';
    }
}
