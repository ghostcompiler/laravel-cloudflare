<p align="center">
  <img src="https://res.cloudinary.com/djgvfl1tv/image/upload/v1780666791/logo_mqnqn4.png" alt="Laravel Cloudflare" width="180">
</p>

<h1 align="center">Laravel Cloudflare SDK</h1>

<p align="center">
  A premium, feature-rich PHP SDK and Laravel integration for the Cloudflare API v4, featuring rate-limit handling, automatic retries, and concurrent batch operations.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11%20%7C%2012%20%7C%2013-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2%20to%208.5-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Cloudflare-API%20v4-F6821F?style=for-the-badge" alt="Cloudflare API">
  <img src="https://img.shields.io/badge/Built%20By-Ghost%20Compiler-0F172A?style=for-the-badge" alt="Ghost Compiler">
</p>

<p align="center">
  <a href="https://packagist.org/packages/ghostcompiler/laravel-cloudflare">
    <img src="https://img.shields.io/packagist/dt/ghostcompiler/laravel-cloudflare?style=flat-square&color=8b5cf6&labelColor=1e1b4b" alt="Packagist Downloads" />
  </a>
  <img src="https://badgen.net/github/stars/ghostcompiler/laravel-cloudflare?color=06b6d4&labelColor=111827&style=flat-square" alt="GitHub Stars" />
</p>

---

## Features

- **100% Endpoint Coverage**: Complete implementation of all zones, DNS, Workers, KV, R2, D1, Access, Turnstile, and 30 resource managers.
- **Fail-Safe Retries & Backoff**: Robust exponential backoff and rate-limit parsing handling `Retry-After` response headers automatically.
- **Concurrently Pooled Processing**: Execute calls asynchronously or concurrently in batches.
- **Dynamic Filter Builder**: Fluent query-building for filtering, page indexing, and sorting.
- **Type-Safe DTOs**: Automated data hydration into standard PHP DTO structures.
- **Custom Exceptions**: Specialized mapping of Cloudflare API status codes and error formats.

---

## Installation

Install the package via Composer:

```bash
composer require ghostcompiler/laravel-cloudflare
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Vendor\Cloudflare\Providers\CloudflareServiceProvider" --tag="config"
```

Add your Cloudflare credentials to your `.env` file:

```env
CLOUDFLARE_TOKEN=your_api_token_here
# Or legacy email/key credentials
CLOUDFLARE_EMAIL=your_email_here
CLOUDFLARE_API_KEY=your_global_api_key_here

CLOUDFLARE_TIMEOUT=30
CLOUDFLARE_RETRIES=3
CLOUDFLARE_RETRY_BACKOFF=100
CLOUDFLARE_LOGGING_ENABLED=true
```

---

## Usage Examples

### Zones

#### Listing Zones
```php
use Vendor\Cloudflare\Facades\Cloudflare;

$zones = Cloudflare::zones()
    ->filter(['status' => 'active'])
    ->perPage(50)
    ->page(1)
    ->get();

foreach ($zones as $zone) {
    echo $zone->name . ': ' . $zone->status . "\n";
}
```

### DNS Records

#### Managing DNS Records for a Zone
```php
// Create a new record
$record = Cloudflare::dns()->create('zone_id_here', [
    'type' => 'A',
    'name' => 'subdomain',
    'content' => '1.2.3.4',
    'proxied' => true,
    'ttl' => 1
]);

// Update the record
Cloudflare::dns()->update('zone_id_here', $record->id, [
    'type' => 'A',
    'name' => 'subdomain',
    'content' => '5.6.7.8',
    'proxied' => false,
    'ttl' => 120
]);

// Delete the record
Cloudflare::dns()->delete('zone_id_here', $record->id);
```

### Worker Scripts

#### Uploading and Managing Workers
```php
Cloudflare::workers()->upload('account_id_here', 'my-script', 'console.log("Hello Worker");');
```

---

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
