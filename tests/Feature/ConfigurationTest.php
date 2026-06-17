<?php

namespace Vendor\Cloudflare\Tests\Feature;

use Vendor\Cloudflare\Http\Client\CloudflareClient;
use Vendor\Cloudflare\Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_config_values_are_loaded()
    {
        $this->assertEquals('test-token', config('cloudflare.token'));
        $this->assertEquals('https://api.cloudflare.com/client/v4', config('cloudflare.base_url'));
    }

    public function test_client_receives_config_values()
    {
        $this->app['config']->set('cloudflare.token', 'custom-token');
        $this->app['config']->set('cloudflare.timeout', 45);

        // Re-resolve client to apply changes
        $client = $this->app->make(CloudflareClient::class);

        // Reflect properties
        $reflection = new \ReflectionClass($client);
        $tokenProp = $reflection->getProperty('token');
        $tokenProp->setAccessible(true);
        $timeoutProp = $reflection->getProperty('timeout');
        $timeoutProp->setAccessible(true);

        $this->assertEquals('custom-token', $tokenProp->getValue($client));
        $this->assertEquals(45, $timeoutProp->getValue($client));
    }
}
