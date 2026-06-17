<?php

namespace Vendor\Cloudflare\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vendor\Cloudflare\Facades\Cloudflare;
use Vendor\Cloudflare\Providers\CloudflareServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CloudflareServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Cloudflare' => Cloudflare::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default config
        $app['config']->set('cloudflare.token', 'test-token');
        $app['config']->set('cloudflare.base_url', 'https://api.cloudflare.com/client/v4');
    }
}
