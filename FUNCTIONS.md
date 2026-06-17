# Laravel Cloudflare SDK - Functions Reference

This file documents every manager, method, helper, and facade call exposed by the package.

---

## Global Helpers / Utilities

```php
// Authenticate on the fly (rebuilds client)
Cloudflare::authenticate('api_token');
Cloudflare::authenticate('email', 'global_api_key');

// Get underlying Guzzle client wrapper
$client = Cloudflare::client();

// Get version of the package
$version = Cloudflare::version();

// Get rate limit details
$limits = Cloudflare::rateLimit();

// Verify connection
$ping = Cloudflare::ping();

// Get health check stats
$health = Cloudflare::health();

// Run concurrent batch requests
$results = Cloudflare::batch([
    fn() => Cloudflare::zones()->find('zone1'),
    fn() => Cloudflare::zones()->find('zone2'),
]);
```

---

## 1. Accounts

```php
Cloudflare::accounts()->all();
Cloudflare::accounts()->paginate($perPage, $page);
Cloudflare::accounts()->find($id);
Cloudflare::accounts()->create($data);
Cloudflare::accounts()->update($id, $data);
Cloudflare::accounts()->delete($id);
Cloudflare::accounts()->members($id);
Cloudflare::accounts()->roles($id);
```

---

## 2. Zones

```php
Cloudflare::zones()->all();
Cloudflare::zones()->paginate($perPage, $page);
Cloudflare::zones()->find($id);
Cloudflare::zones()->create($data);
Cloudflare::zones()->update($id, $data);
Cloudflare::zones()->delete($id);
Cloudflare::zones()->activationCheck($id);
Cloudflare::zones()->purgeCache($id, $data);
```

---

## 3. Zone Settings

```php
Cloudflare::zoneSettings()->all($zoneId);
Cloudflare::zoneSettings()->find($zoneId, $settingName);
Cloudflare::zoneSettings()->update($zoneId, $settingName, $data);
Cloudflare::zoneSettings()->updateMultiple($zoneId, $data);
```

---

## 4. DNS Records

```php
Cloudflare::dns()->all($zoneId);
Cloudflare::dns()->paginate($zoneId, $perPage, $page);
Cloudflare::dns()->find($zoneId, $id);
Cloudflare::dns()->create($zoneId, $data);
Cloudflare::dns()->update($zoneId, $id, $data);
Cloudflare::dns()->delete($zoneId, $id);
Cloudflare::dns()->import($zoneId, $fileContent);
Cloudflare::dns()->export($zoneId);
Cloudflare::dns()->scan($zoneId);
```

---

## 5. SSL Certificates

```php
Cloudflare::sslCertificates()->all($zoneId);
Cloudflare::sslCertificates()->find($zoneId, $id);
Cloudflare::sslCertificates()->create($zoneId, $data);
Cloudflare::sslCertificates()->update($zoneId, $id, $data);
Cloudflare::sslCertificates()->delete($zoneId, $id);
Cloudflare::sslCertificates()->reprioritize($zoneId, $data);
```

---

## 6. Certificate Packs

```php
Cloudflare::certificatePacks()->all($zoneId);
Cloudflare::certificatePacks()->find($zoneId, $id);
Cloudflare::certificatePacks()->order($zoneId, $data);
Cloudflare::certificatePacks()->delete($zoneId, $id);
```

---

## 7. Custom Hostnames

```php
Cloudflare::customHostnames()->all($zoneId);
Cloudflare::customHostnames()->paginate($zoneId, $perPage, $page);
Cloudflare::customHostnames()->find($zoneId, $id);
Cloudflare::customHostnames()->create($zoneId, $data);
Cloudflare::customHostnames()->update($zoneId, $id, $data);
Cloudflare::customHostnames()->delete($zoneId, $id);
```

---

## 8. Firewall Rules

```php
Cloudflare::firewallRules()->all($zoneId);
Cloudflare::firewallRules()->paginate($zoneId, $perPage, $page);
Cloudflare::firewallRules()->find($zoneId, $id);
Cloudflare::firewallRules()->create($zoneId, $data);
Cloudflare::firewallRules()->update($zoneId, $id, $data);
Cloudflare::firewallRules()->delete($zoneId, $id);
```

---

## 9. Rulesets

```php
Cloudflare::rulesets()->all($zoneOrAccountId, $isAccount);
Cloudflare::rulesets()->find($zoneOrAccountId, $id, $isAccount);
Cloudflare::rulesets()->create($zoneOrAccountId, $data, $isAccount);
Cloudflare::rulesets()->update($zoneOrAccountId, $id, $data, $isAccount);
Cloudflare::rulesets()->delete($zoneOrAccountId, $id, $isAccount);
```

---

## 10. Page Rules

```php
Cloudflare::pageRules()->all($zoneId);
Cloudflare::pageRules()->find($zoneId, $id);
Cloudflare::pageRules()->create($zoneId, $data);
Cloudflare::pageRules()->update($zoneId, $id, $data);
Cloudflare::pageRules()->delete($zoneId, $id);
```

---

## 11. Cache Purge

```php
Cloudflare::cache()->purgeAll($zoneId);
Cloudflare::cache()->purgeFiles($zoneId, $files);
Cloudflare::cache()->purgeTags($zoneId, $tags);
Cloudflare::cache()->purgeHosts($zoneId, $hosts);
Cloudflare::cache()->purgePrefixes($zoneId, $prefixes);
```

---

## 12. Load Balancers

```php
Cloudflare::loadBalancers()->all($zoneId);
Cloudflare::loadBalancers()->find($zoneId, $id);
Cloudflare::loadBalancers()->create($zoneId, $data);
Cloudflare::loadBalancers()->update($zoneId, $id, $data);
Cloudflare::loadBalancers()->delete($zoneId, $id);
```

---

## 13. Load Balancer Pools

```php
Cloudflare::loadBalancerPools()->all($accountId);
Cloudflare::loadBalancerPools()->find($accountId, $id);
Cloudflare::loadBalancerPools()->create($accountId, $data);
Cloudflare::loadBalancerPools()->update($accountId, $id, $data);
Cloudflare::loadBalancerPools()->delete($accountId, $id);
Cloudflare::loadBalancerPools()->health($accountId, $id);
```

---

## 14. Load Balancer Monitors

```php
Cloudflare::loadBalancerMonitors()->all($accountId);
Cloudflare::loadBalancerMonitors()->find($accountId, $id);
Cloudflare::loadBalancerMonitors()->create($accountId, $data);
Cloudflare::loadBalancerMonitors()->update($accountId, $id, $data);
Cloudflare::loadBalancerMonitors()->delete($accountId, $id);
```

---

## 15. Workers

```php
Cloudflare::workers()->all($accountId);
Cloudflare::workers()->find($accountId, $name);
Cloudflare::workers()->upload($accountId, $name, $scriptContent, $metadata);
Cloudflare::workers()->delete($accountId, $name);
Cloudflare::workers()->getSettings($accountId, $name);
Cloudflare::workers()->updateSettings($accountId, $name, $settings);
```

---

## 16. Worker Routes

```php
Cloudflare::workerRoutes()->all($zoneId);
Cloudflare::workerRoutes()->find($zoneId, $id);
Cloudflare::workerRoutes()->create($zoneId, $data);
Cloudflare::workerRoutes()->update($zoneId, $id, $data);
Cloudflare::workerRoutes()->delete($zoneId, $id);
```

---

## 17. KV Storage

```php
Cloudflare::kv()->all($accountId);
Cloudflare::kv()->paginate($accountId, $perPage, $page);
Cloudflare::kv()->create($accountId, $data);
Cloudflare::kv()->rename($accountId, $id, $title);
Cloudflare::kv()->delete($accountId, $id);
Cloudflare::kv()->keys($accountId, $id);
Cloudflare::kv()->getValue($accountId, $id, $key);
Cloudflare::kv()->putValue($accountId, $id, $key, $value);
Cloudflare::kv()->deleteKey($accountId, $id, $key);
Cloudflare::kv()->bulkWrite($accountId, $id, $keyValues);
Cloudflare::kv()->bulkDelete($accountId, $id, $keys);
```

---

## 18. R2 Storage

```php
Cloudflare::r2()->all($accountId);
Cloudflare::r2()->find($accountId, $name);
Cloudflare::r2()->create($accountId, $data);
Cloudflare::r2()->delete($accountId, $name);
```

---

## 19. D1 Databases

```php
Cloudflare::d1()->all($accountId);
Cloudflare::d1()->find($accountId, $id);
Cloudflare::d1()->create($accountId, $data);
Cloudflare::d1()->delete($accountId, $id);
Cloudflare::d1()->query($accountId, $id, $sql, $params);
Cloudflare::d1()->raw($accountId, $id, $sql, $params);
```

---

## 20. Pages Projects

```php
Cloudflare::pages()->all($accountId);
Cloudflare::pages()->find($accountId, $name);
Cloudflare::pages()->create($accountId, $data);
Cloudflare::pages()->update($accountId, $name, $data);
Cloudflare::pages()->delete($accountId, $name);
Cloudflare::pages()->deployments($accountId, $projectName);
```

---

## 21. Cloudflare Images

```php
Cloudflare::images()->all($accountId);
Cloudflare::images()->find($accountId, $id);
Cloudflare::images()->upload($accountId, $fileContent, $metadata);
Cloudflare::images()->update($accountId, $id, $data);
Cloudflare::images()->delete($accountId, $id);
Cloudflare::images()->directUpload($accountId);
Cloudflare::images()->stats($accountId);
```

---

## 22. Cloudflare Stream

```php
Cloudflare::stream()->all($accountId);
Cloudflare::stream()->find($accountId, $uid);
Cloudflare::stream()->upload($accountId, $fileContent);
Cloudflare::stream()->copy($accountId, $url);
Cloudflare::stream()->update($accountId, $uid, $data);
Cloudflare::stream()->delete($accountId, $uid);
Cloudflare::stream()->embed($accountId, $uid);
Cloudflare::stream()->token($accountId, $uid);
```

---

## 23. Email Routing

```php
Cloudflare::emailRouting()->getSettings($zoneId);
Cloudflare::emailRouting()->enable($zoneId);
Cloudflare::emailRouting()->disable($zoneId);
Cloudflare::emailRouting()->rules($zoneId);
Cloudflare::emailRouting()->catchAll($zoneId);
```

---

## 24. Zero Trust Access Applications

```php
Cloudflare::access()->all($accountId);
Cloudflare::access()->find($accountId, $id);
Cloudflare::access()->create($accountId, $data);
Cloudflare::access()->update($accountId, $id, $data);
Cloudflare::access()->delete($accountId, $id);
Cloudflare::access()->policies($accountId, $appId);
```

---

## 25. Cloudflare Tunnels

```php
Cloudflare::tunnels()->all($accountId);
Cloudflare::tunnels()->find($accountId, $id);
Cloudflare::tunnels()->create($accountId, $data);
Cloudflare::tunnels()->update($accountId, $id, $data);
Cloudflare::tunnels()->delete($accountId, $id);
Cloudflare::tunnels()->getToken($accountId, $id);
Cloudflare::tunnels()->cleanConnections($accountId, $id);
```

---

## 26. Turnstile Widgets

```php
Cloudflare::turnstile()->all($accountId);
Cloudflare::turnstile()->find($accountId, $sitekey);
Cloudflare::turnstile()->create($accountId, $data);
Cloudflare::turnstile()->update($accountId, $sitekey, $data);
Cloudflare::turnstile()->delete($accountId, $sitekey);
Cloudflare::turnstile()->rotateSecret($accountId, $sitekey);
```

---

## 27. Healthchecks

```php
Cloudflare::healthchecks()->all($zoneId);
Cloudflare::healthchecks()->find($zoneId, $id);
Cloudflare::healthchecks()->create($zoneId, $data);
Cloudflare::healthchecks()->update($zoneId, $id, $data);
Cloudflare::healthchecks()->delete($zoneId, $id);
```

---

## 28. Waiting Rooms

```php
Cloudflare::waitingRooms()->all($zoneId);
Cloudflare::waitingRooms()->find($zoneId, $id);
Cloudflare::waitingRooms()->create($zoneId, $data);
Cloudflare::waitingRooms()->update($zoneId, $id, $data);
Cloudflare::waitingRooms()->delete($zoneId, $id);
Cloudflare::waitingRooms()->status($zoneId, $id);
```

---

## 29. Logpush Jobs

```php
Cloudflare::logpush()->all($zoneId);
Cloudflare::logpush()->find($zoneId, $id);
Cloudflare::logpush()->create($zoneId, $data);
Cloudflare::logpush()->update($zoneId, $id, $data);
Cloudflare::logpush()->delete($zoneId, $id);
Cloudflare::logpush()->validateOwnership($zoneId, $data);
```

---

## 30. User Profile & Tokens

```php
Cloudflare::user()->get();
Cloudflare::user()->update($data);
Cloudflare::user()->tokens();
Cloudflare::user()->verifyToken();
```
