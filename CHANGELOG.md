# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-06-17

### Added
- Initial release of the production-ready Cloudflare Laravel SDK.
- 100% coverage of all 30 Cloudflare API resources: Accounts, Zones, Zone Settings, DNS, SSL, Certificate Packs, Custom Hostnames, Firewall Rules, Rulesets, Page Rules, Cache, Load Balancers, Pools, Monitors, Workers, Routes, KV, R2, D1, Pages, Images, Stream, Email Routing, Access Apps, Tunnels, Turnstile, Healthchecks, Waiting Rooms, Logpush, and User Profile.
- Retry mechanisms with exponential backoff and `Retry-After` header handling.
- Concurrency via Guzzle promise mapping for asynchronous calls and batch requests.
- Custom exception mapping for all HTTP error statuses.
- Configuration publish, service provider container binds, and Laravel Facade support.
- Fully compatible with PHP 8.2 through PHP 8.5.
- Supported on Laravel 11 through Laravel 13.

## [1.0.2] - 2026-06-17

### Changed
- Cleaned up unused variable warnings and improved inline comments.


## [1.0.3] - 2026-06-17

### Added
- Added developer contribution guidelines clarification in CONTRIBUTING.md.


## [1.0.4] - 2026-06-17

### Fixed
- Refined test coverage and workflows configuration.


## [1.0.5] - 2026-06-17

### Fixed
- Fixed Pint style issues across the codebase to resolve GitHub Actions build checks.

