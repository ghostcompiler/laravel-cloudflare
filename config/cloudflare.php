<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudflare API Token
    |--------------------------------------------------------------------------
    |
    | Your Cloudflare API Token. You can generate one in the Cloudflare
    | Dashboard under My Profile > API Tokens.
    |
    | This is the recommended authentication method.
    |
    */
    'token' => env('CLOUDFLARE_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Global API Key (Legacy)
    |--------------------------------------------------------------------------
    |
    | Your Cloudflare Global API Key and email. This is the legacy
    | authentication method. Use API Tokens instead when possible.
    |
    */
    'email' => env('CLOUDFLARE_EMAIL'),
    'api_key' => env('CLOUDFLARE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base API URL
    |--------------------------------------------------------------------------
    |
    | The base URL of the Cloudflare API v4.
    |
    */
    'base_url' => env('CLOUDFLARE_BASE_URL', 'https://api.cloudflare.com/client/v4'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The default request timeout in seconds.
    |
    */
    'timeout' => (int) env('CLOUDFLARE_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for rate limit retries and server error retries.
    |
    */
    'retries' => (int) env('CLOUDFLARE_RETRIES', 3),
    'retry_backoff' => (int) env('CLOUDFLARE_RETRY_BACKOFF', 100), // ms multiplier

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | When enabled, requests and responses will be logged using Laravel's
    | Log service.
    |
    */
    'logging' => [
        'enabled' => (bool) env('CLOUDFLARE_LOGGING_ENABLED', false),
        'channel' => env('CLOUDFLARE_LOGGING_CHANNEL'),
    ],
];
