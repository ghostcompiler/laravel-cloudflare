<?php

namespace Vendor\Cloudflare\Tests\Feature;

use Vendor\Cloudflare\Facades\Cloudflare;
use Vendor\Cloudflare\Http\Client\CloudflareClient;
use Vendor\Cloudflare\Managers\CloudflareManager;
use Vendor\Cloudflare\Managers\ZoneManager;
use Vendor\Cloudflare\Managers\AccountManager;
use Vendor\Cloudflare\Tests\TestCase;

class LaravelIntegrationTest extends TestCase
{
    public function test_facade_resolves_to_manager()
    {
        $manager = Cloudflare::getFacadeRoot();
        $this->assertInstanceOf(CloudflareManager::class, $manager);
    }

    public function test_container_resolves_singleton_manager()
    {
        $manager1 = $this->app->make(CloudflareManager::class);
        $manager2 = $this->app->make('cloudflare');

        $this->assertSame($manager1, $manager2);
    }

    public function test_container_resolves_singleton_client()
    {
        $client = $this->app->make(CloudflareClient::class);
        $manager = $this->app->make(CloudflareManager::class);

        $this->assertSame($client, $manager->client());
    }

    public function test_facade_submanagers()
    {
        $this->assertInstanceOf(ZoneManager::class, Cloudflare::zones());
        $this->assertInstanceOf(AccountManager::class, Cloudflare::accounts());
    }
}
