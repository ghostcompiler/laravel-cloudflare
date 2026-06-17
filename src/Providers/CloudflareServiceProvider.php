<?php

namespace Vendor\Cloudflare\Providers;

use Illuminate\Support\ServiceProvider;
use Vendor\Cloudflare\Http\Client\CloudflareClient;
use Vendor\Cloudflare\Managers\CloudflareManager;

class CloudflareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/cloudflare.php',
            'cloudflare'
        );

        // Bind CloudflareClient
        $this->app->singleton(CloudflareClient::class, function ($app) {
            $config = $app['config']->get('cloudflare', []);

            return new CloudflareClient(
                $config['token'] ?? '',
                $config['email'] ?? '',
                $config['api_key'] ?? '',
                $config
            );
        });

        // Bind CloudflareManager
        $this->app->singleton(CloudflareManager::class, function ($app) {
            return new CloudflareManager($app->make(CloudflareClient::class));
        });

        // Register alias
        $this->app->alias(CloudflareManager::class, 'cloudflare');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/cloudflare.php' => config_path('cloudflare.php'),
            ], 'config');
        }
    }
}
