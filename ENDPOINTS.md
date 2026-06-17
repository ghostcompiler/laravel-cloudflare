# Cloudflare API Endpoints to SDK Methods Mapping

This document maps every endpoint in the Cloudflare API v4 to its corresponding SDK manager method.

## Accounts

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts` | `Cloudflare::accounts()->all()` |
| `POST` | `/accounts` | `Cloudflare::accounts()->create($data)` |
| `GET` | `/accounts/{id}` | `Cloudflare::accounts()->find($id)` |
| `PUT` | `/accounts/{id}` | `Cloudflare::accounts()->update($id, $data)` |
| `DELETE` | `/accounts/{id}` | `Cloudflare::accounts()->delete($id)` |
| `GET` | `/accounts/{id}/members` | `Cloudflare::accounts()->members($id)` |
| `GET` | `/accounts/{id}/roles` | `Cloudflare::accounts()->roles($id)` |

## Zones

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones` | `Cloudflare::zones()->all()` |
| `POST` | `/zones` | `Cloudflare::zones()->create($data)` |
| `GET` | `/zones/{id}` | `Cloudflare::zones()->find($id)` |
| `PATCH` | `/zones/{id}` | `Cloudflare::zones()->update($id, $data)` |
| `DELETE` | `/zones/{id}` | `Cloudflare::zones()->delete($id)` |
| `POST` | `/zones/{id}/activation_check` | `Cloudflare::zones()->activationCheck($id)` |
| `POST` | `/zones/{id}/purge_cache` | `Cloudflare::zones()->purgeCache($id, $data)` |

## Zone Settings

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/settings` | `Cloudflare::zoneSettings()->all($zoneId)` |
| `PATCH` | `/zones/{zoneId}/settings` | `Cloudflare::zoneSettings()->updateMultiple($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/settings/{setting_name}` | `Cloudflare::zoneSettings()->find($zoneId, $setting_name)` |
| `PATCH` | `/zones/{zoneId}/settings/{setting_name}` | `Cloudflare::zoneSettings()->update($zoneId, $setting_name, $data)` |

## DNS Records

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/dns_records` | `Cloudflare::dns()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/dns_records` | `Cloudflare::dns()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/dns_records/{id}` | `Cloudflare::dns()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/dns_records/{id}` | `Cloudflare::dns()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/dns_records/{id}` | `Cloudflare::dns()->delete($zoneId, $id)` |
| `POST` | `/zones/{zoneId}/dns_records/import` | `Cloudflare::dns()->import($zoneId, $fileContent)` |
| `GET` | `/zones/{zoneId}/dns_records/export` | `Cloudflare::dns()->export($zoneId)` |
| `POST` | `/zones/{zoneId}/dns_records/scan` | `Cloudflare::dns()->scan($zoneId)` |

## SSL Certificates & Packs

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/custom_certificates` | `Cloudflare::sslCertificates()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/custom_certificates` | `Cloudflare::sslCertificates()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/custom_certificates/{id}` | `Cloudflare::sslCertificates()->find($zoneId, $id)` |
| `PATCH` | `/zones/{zoneId}/custom_certificates/{id}` | `Cloudflare::sslCertificates()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/custom_certificates/{id}` | `Cloudflare::sslCertificates()->delete($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/custom_certificates/prioritize` | `Cloudflare::sslCertificates()->reprioritize($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/ssl/certificate_packs` | `Cloudflare::certificatePacks()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/ssl/certificate_packs` | `Cloudflare::certificatePacks()->order($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/ssl/certificate_packs/{id}` | `Cloudflare::certificatePacks()->find($zoneId, $id)` |
| `DELETE` | `/zones/{zoneId}/ssl/certificate_packs/{id}` | `Cloudflare::certificatePacks()->delete($zoneId, $id)` |

## Custom Hostnames

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/custom_hostnames` | `Cloudflare::customHostnames()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/custom_hostnames` | `Cloudflare::customHostnames()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/custom_hostnames/{id}` | `Cloudflare::customHostnames()->find($zoneId, $id)` |
| `PATCH` | `/zones/{zoneId}/custom_hostnames/{id}` | `Cloudflare::customHostnames()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/custom_hostnames/{id}` | `Cloudflare::customHostnames()->delete($zoneId, $id)` |

## Firewall & Page Rules

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/firewall/rules` | `Cloudflare::firewallRules()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/firewall/rules` | `Cloudflare::firewallRules()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/firewall/rules/{id}` | `Cloudflare::firewallRules()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/firewall/rules/{id}` | `Cloudflare::firewallRules()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/firewall/rules/{id}` | `Cloudflare::firewallRules()->delete($zoneId, $id)` |
| `GET` | `/zones/{zoneId}/pagerules` | `Cloudflare::pageRules()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/pagerules` | `Cloudflare::pageRules()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/pagerules/{id}` | `Cloudflare::pageRules()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/pagerules/{id}` | `Cloudflare::pageRules()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/pagerules/{id}` | `Cloudflare::pageRules()->delete($zoneId, $id)` |

## Rulesets

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/rulesets` | `Cloudflare::rulesets()->all($zoneId, false)` |
| `GET` | `/accounts/{accountId}/rulesets` | `Cloudflare::rulesets()->all($accountId, true)` |
| `POST` | `/zones/{zoneId}/rulesets` | `Cloudflare::rulesets()->create($zoneId, $data, false)` |
| `GET` | `/zones/{zoneId}/rulesets/{id}` | `Cloudflare::rulesets()->find($zoneId, $id, false)` |

## Cache

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `POST` | `/zones/{zoneId}/purge_cache` (everything) | `Cloudflare::cache()->purgeAll($zoneId)` |
| `POST` | `/zones/{zoneId}/purge_cache` (files) | `Cloudflare::cache()->purgeFiles($zoneId, $files)` |
| `POST` | `/zones/{zoneId}/purge_cache` (tags) | `Cloudflare::cache()->purgeTags($zoneId, $tags)` |

## Load Balancers, Pools, Monitors

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/load_balancers` | `Cloudflare::loadBalancers()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/load_balancers` | `Cloudflare::loadBalancers()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/load_balancers/{id}` | `Cloudflare::loadBalancers()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/load_balancers/{id}` | `Cloudflare::loadBalancers()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/load_balancers/{id}` | `Cloudflare::loadBalancers()->delete($zoneId, $id)` |
| `GET` | `/accounts/{accountId}/load_balancers/pools` | `Cloudflare::loadBalancerPools()->all($accountId)` |
| `POST` | `/accounts/{accountId}/load_balancers/pools` | `Cloudflare::loadBalancerPools()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/load_balancers/pools/{id}` | `Cloudflare::loadBalancerPools()->find($accountId, $id)` |
| `PUT` | `/accounts/{accountId}/load_balancers/pools/{id}` | `Cloudflare::loadBalancerPools()->update($accountId, $id, $data)` |
| `DELETE` | `/accounts/{accountId}/load_balancers/pools/{id}` | `Cloudflare::loadBalancerPools()->delete($accountId, $id)` |
| `GET` | `/accounts/{accountId}/load_balancers/pools/{id}/health` | `Cloudflare::loadBalancerPools()->health($accountId, $id)` |
| `GET` | `/accounts/{accountId}/load_balancers/monitors` | `Cloudflare::loadBalancerMonitors()->all($accountId)` |
| `POST` | `/accounts/{accountId}/load_balancers/monitors` | `Cloudflare::loadBalancerMonitors()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/load_balancers/monitors/{id}` | `Cloudflare::loadBalancerMonitors()->find($accountId, $id)` |
| `PUT` | `/accounts/{accountId}/load_balancers/monitors/{id}` | `Cloudflare::loadBalancerMonitors()->update($accountId, $id, $data)` |
| `DELETE` | `/accounts/{accountId}/load_balancers/monitors/{id}` | `Cloudflare::loadBalancerMonitors()->delete($accountId, $id)` |

## Worker Scripts & Routes

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/workers/scripts` | `Cloudflare::workers()->all($accountId)` |
| `PUT` | `/accounts/{accountId}/workers/scripts/{name}` | `Cloudflare::workers()->upload($accountId, $name, $script, $metadata)` |
| `GET` | `/accounts/{accountId}/workers/scripts/{name}` | `Cloudflare::workers()->find($accountId, $name)` |
| `DELETE` | `/accounts/{accountId}/workers/scripts/{name}` | `Cloudflare::workers()->delete($accountId, $name)` |
| `GET` | `/accounts/{accountId}/workers/scripts/{name}/settings` | `Cloudflare::workers()->getSettings($accountId, $name)` |
| `PATCH` | `/accounts/{accountId}/workers/scripts/{name}/settings` | `Cloudflare::workers()->updateSettings($accountId, $name, $settings)` |
| `GET` | `/zones/{zoneId}/workers/routes` | `Cloudflare::workerRoutes()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/workers/routes` | `Cloudflare::workerRoutes()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/workers/routes/{id}` | `Cloudflare::workerRoutes()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/workers/routes/{id}` | `Cloudflare::workerRoutes()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/workers/routes/{id}` | `Cloudflare::workerRoutes()->delete($zoneId, $id)` |

## KV Storage

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/storage/kv/namespaces` | `Cloudflare::kv()->all($accountId)` |
| `POST` | `/accounts/{accountId}/storage/kv/namespaces` | `Cloudflare::kv()->create($accountId, $data)` |
| `PUT` | `/accounts/{accountId}/storage/kv/namespaces/{id}` | `Cloudflare::kv()->rename($accountId, $id, $title)` |
| `DELETE` | `/accounts/{accountId}/storage/kv/namespaces/{id}` | `Cloudflare::kv()->delete($accountId, $id)` |
| `GET` | `/accounts/{accountId}/storage/kv/namespaces/{id}/keys` | `Cloudflare::kv()->keys($accountId, $id)` |
| `GET` | `/accounts/{accountId}/storage/kv/namespaces/{id}/values/{key}` | `Cloudflare::kv()->getValue($accountId, $id, $key)` |
| `PUT` | `/accounts/{accountId}/storage/kv/namespaces/{id}/values/{key}` | `Cloudflare::kv()->putValue($accountId, $id, $key, $value)` |
| `DELETE` | `/accounts/{accountId}/storage/kv/namespaces/{id}/values/{key}` | `Cloudflare::kv()->deleteKey($accountId, $id, $key)` |
| `POST` | `/accounts/{accountId}/storage/kv/namespaces/{id}/bulk` | `Cloudflare::kv()->bulkWrite($accountId, $id, $keyValues)` |
| `DELETE` | `/accounts/{accountId}/storage/kv/namespaces/{id}/bulk` | `Cloudflare::kv()->bulkDelete($accountId, $id, $keys)` |

## R2 Storage

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/r2/buckets` | `Cloudflare::r2()->all($accountId)` |
| `POST` | `/accounts/{accountId}/r2/buckets` | `Cloudflare::r2()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/r2/buckets/{name}` | `Cloudflare::r2()->find($accountId, $name)` |
| `DELETE` | `/accounts/{accountId}/r2/buckets/{name}` | `Cloudflare::r2()->delete($accountId, $name)` |

## D1 Databases

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/d1/database` | `Cloudflare::d1()->all($accountId)` |
| `POST` | `/accounts/{accountId}/d1/database` | `Cloudflare::d1()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/d1/database/{id}` | `Cloudflare::d1()->find($accountId, $id)` |
| `DELETE` | `/accounts/{accountId}/d1/database/{id}` | `Cloudflare::d1()->delete($accountId, $id)` |
| `POST` | `/accounts/{accountId}/d1/database/{id}/query` | `Cloudflare::d1()->query($accountId, $id, $sql, $params)` |
| `POST` | `/accounts/{accountId}/d1/database/{id}/raw` | `Cloudflare::d1()->raw($accountId, $id, $sql, $params)` |

## Pages Projects

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/pages/projects` | `Cloudflare::pages()->all($accountId)` |
| `POST` | `/accounts/{accountId}/pages/projects` | `Cloudflare::pages()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/pages/projects/{name}` | `Cloudflare::pages()->find($accountId, $name)` |
| `PATCH` | `/accounts/{accountId}/pages/projects/{name}` | `Cloudflare::pages()->update($accountId, $name, $data)` |
| `DELETE` | `/accounts/{accountId}/pages/projects/{name}` | `Cloudflare::pages()->delete($accountId, $name)` |
| `GET` | `/accounts/{accountId}/pages/projects/{projectName}/deployments` | `Cloudflare::pages()->deployments($accountId, $projectName)` |

## Images & Stream

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/images/v1` | `Cloudflare::images()->all($accountId)` |
| `POST` | `/accounts/{accountId}/images/v1` | `Cloudflare::images()->upload($accountId, $fileContent, $metadata)` |
| `GET` | `/accounts/{accountId}/images/v1/{id}` | `Cloudflare::images()->find($accountId, $id)` |
| `PATCH` | `/accounts/{accountId}/images/v1/{id}` | `Cloudflare::images()->update($accountId, $id, $data)` |
| `DELETE` | `/accounts/{accountId}/images/v1/{id}` | `Cloudflare::images()->delete($accountId, $id)` |
| `POST` | `/accounts/{accountId}/images/v1/direct_upload` | `Cloudflare::images()->directUpload($accountId)` |
| `GET` | `/accounts/{accountId}/images/v1/stats` | `Cloudflare::images()->stats($accountId)` |
| `GET` | `/accounts/{accountId}/stream` | `Cloudflare::stream()->all($accountId)` |
| `POST` | `/accounts/{accountId}/stream` | `Cloudflare::stream()->upload($accountId, $fileContent)` |
| `POST` | `/accounts/{accountId}/stream/copy` | `Cloudflare::stream()->copy($accountId, $url)` |
| `GET` | `/accounts/{accountId}/stream/{uid}` | `Cloudflare::stream()->find($accountId, $uid)` |
| `POST` | `/accounts/{accountId}/stream/{uid}` | `Cloudflare::stream()->update($accountId, $uid, $data)` |
| `DELETE` | `/accounts/{accountId}/stream/{uid}` | `Cloudflare::stream()->delete($accountId, $uid)` |
| `GET` | `/accounts/{accountId}/stream/{uid}/embed` | `Cloudflare::stream()->embed($accountId, $uid)` |
| `POST` | `/accounts/{accountId}/stream/{uid}/token` | `Cloudflare::stream()->token($accountId, $uid)` |

## Email Routing

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/email/routing` | `Cloudflare::emailRouting()->getSettings($zoneId)` |
| `POST` | `/zones/{zoneId}/email/routing/enable` | `Cloudflare::emailRouting()->enable($zoneId)` |
| `POST` | `/zones/{zoneId}/email/routing/disable` | `Cloudflare::emailRouting()->disable($zoneId)` |
| `GET` | `/zones/{zoneId}/email/routing/rules` | `Cloudflare::emailRouting()->rules($zoneId)` |
| `GET` | `/zones/{zoneId}/email/routing/catch_all` | `Cloudflare::emailRouting()->catchAll($zoneId)` |

## Zero Trust Access

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/access/apps` | `Cloudflare::access()->all($accountId)` |
| `POST` | `/accounts/{accountId}/access/apps` | `Cloudflare::access()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/access/apps/{id}` | `Cloudflare::access()->find($accountId, $id)` |
| `PUT` | `/accounts/{accountId}/access/apps/{id}` | `Cloudflare::access()->update($accountId, $id, $data)` |
| `DELETE` | `/accounts/{accountId}/access/apps/{id}` | `Cloudflare::access()->delete($accountId, $id)` |
| `GET` | `/accounts/{accountId}/access/apps/{appId}/policies` | `Cloudflare::access()->policies($accountId, $appId)` |

## Tunnels

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/cfd_tunnel` | `Cloudflare::tunnels()->all($accountId)` |
| `POST` | `/accounts/{accountId}/cfd_tunnel` | `Cloudflare::tunnels()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/cfd_tunnel/{id}` | `Cloudflare::tunnels()->find($accountId, $id)` |
| `PATCH` | `/accounts/{accountId}/cfd_tunnel/{id}` | `Cloudflare::tunnels()->update($accountId, $id, $data)` |
| `DELETE` | `/accounts/{accountId}/cfd_tunnel/{id}` | `Cloudflare::tunnels()->delete($accountId, $id)` |
| `GET` | `/accounts/{accountId}/cfd_tunnel/{id}/token` | `Cloudflare::tunnels()->getToken($accountId, $id)` |
| `POST` | `/accounts/{accountId}/cfd_tunnel/{id}/connections/clean` | `Cloudflare::tunnels()->cleanConnections($accountId, $id)` |

## Turnstile

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/accounts/{accountId}/challenges/widgets` | `Cloudflare::turnstile()->all($accountId)` |
| `POST` | `/accounts/{accountId}/challenges/widgets` | `Cloudflare::turnstile()->create($accountId, $data)` |
| `GET` | `/accounts/{accountId}/challenges/widgets/{sitekey}` | `Cloudflare::turnstile()->find($accountId, $sitekey)` |
| `PUT` | `/accounts/{accountId}/challenges/widgets/{sitekey}` | `Cloudflare::turnstile()->update($accountId, $sitekey, $data)` |
| `DELETE` | `/accounts/{accountId}/challenges/widgets/{sitekey}` | `Cloudflare::turnstile()->delete($accountId, $sitekey)` |
| `POST` | `/accounts/{accountId}/challenges/widgets/{sitekey}/rotate_secret` | `Cloudflare::turnstile()->rotateSecret($accountId, $sitekey)` |

## Healthchecks & Waiting Rooms

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/healthchecks` | `Cloudflare::healthchecks()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/healthchecks` | `Cloudflare::healthchecks()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/healthchecks/{id}` | `Cloudflare::healthchecks()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/healthchecks/{id}` | `Cloudflare::healthchecks()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/healthchecks/{id}` | `Cloudflare::healthchecks()->delete($zoneId, $id)` |
| `GET` | `/zones/{zoneId}/waiting_rooms` | `Cloudflare::waitingRooms()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/waiting_rooms` | `Cloudflare::waitingRooms()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/waiting_rooms/{id}` | `Cloudflare::waitingRooms()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/waiting_rooms/{id}` | `Cloudflare::waitingRooms()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/waiting_rooms/{id}` | `Cloudflare::waitingRooms()->delete($zoneId, $id)` |
| `GET` | `/zones/{zoneId}/waiting_rooms/{id}/status` | `Cloudflare::waitingRooms()->status($zoneId, $id)` |

## Logpush

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/zones/{zoneId}/logpush/jobs` | `Cloudflare::logpush()->all($zoneId)` |
| `POST` | `/zones/{zoneId}/logpush/jobs` | `Cloudflare::logpush()->create($zoneId, $data)` |
| `GET` | `/zones/{zoneId}/logpush/jobs/{id}` | `Cloudflare::logpush()->find($zoneId, $id)` |
| `PUT` | `/zones/{zoneId}/logpush/jobs/{id}` | `Cloudflare::logpush()->update($zoneId, $id, $data)` |
| `DELETE` | `/zones/{zoneId}/logpush/jobs/{id}` | `Cloudflare::logpush()->delete($zoneId, $id)` |
| `POST` | `/zones/{zoneId}/logpush/ownership` | `Cloudflare::logpush()->validateOwnership($zoneId, $data)` |

## User

| HTTP Method | API Endpoint | SDK Method |
| ----------- | ------------ | ---------- |
| `GET` | `/user` | `Cloudflare::user()->get()` |
| `PATCH` | `/user` | `Cloudflare::user()->update($data)` |
| `GET` | `/user/tokens` | `Cloudflare::user()->tokens()` |
| `GET` | `/user/tokens/verify` | `Cloudflare::user()->verifyToken()` |
