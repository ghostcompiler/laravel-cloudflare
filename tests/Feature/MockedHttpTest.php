<?php

namespace Vendor\Cloudflare\Tests\Feature;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vendor\Cloudflare\Collections\ZoneCollection;
use Vendor\Cloudflare\DTOs\Zone;
use Vendor\Cloudflare\Exceptions\AuthenticationException;
use Vendor\Cloudflare\Exceptions\NetworkException;
use Vendor\Cloudflare\Exceptions\ValidationException;
use Vendor\Cloudflare\Http\Client\CloudflareClient;
use Vendor\Cloudflare\Http\Middleware\RetryMiddleware;
use Vendor\Cloudflare\Managers\CloudflareManager;
use Vendor\Cloudflare\Tests\TestCase;

class MockedHttpTest extends TestCase
{
    private function createMockClient(array $responses, int $maxRetries = 3, int $retryBackoff = 0): CloudflareClient
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);

        // Add retry middleware
        $retry = new RetryMiddleware($maxRetries, $retryBackoff);
        $stack->push(Middleware::retry($retry->decider(), $retry->delay()));

        $guzzle = new GuzzleClient([
            'handler' => $stack,
            'base_uri' => 'https://api.cloudflare.com/client/v4/',
        ]);

        $client = new CloudflareClient('mock-token', '', '', [
            'base_url' => 'https://api.cloudflare.com/client/v4',
            'retries' => $maxRetries,
            'retry_backoff' => $retryBackoff,
        ]);
        $client->setGuzzleClient($guzzle);

        return $client;
    }

    public function test_get_zones_success()
    {
        $responseBody = json_encode([
            'success' => true,
            'errors' => [],
            'result' => [
                ['id' => 'zone1', 'name' => 'ghost-1.com', 'status' => 'active'],
                ['id' => 'zone2', 'name' => 'ghost-2.com', 'status' => 'pending'],
            ],
        ]);

        $client = $this->createMockClient([
            new Response(
                200,
                [
                    'X-RateLimit-Limit' => '1200',
                    'X-RateLimit-Remaining' => '1199',
                    'X-RateLimit-Reset' => '60',
                ],
                $responseBody
            ),
        ]);

        $manager = new CloudflareManager($client);

        $zones = $manager->zones()->all();

        $this->assertCount(2, $zones);
        $this->assertEquals('ghost-1.com', $zones->first()->name);

        $limits = $manager->rateLimit();
        $this->assertEquals(1200, $limits['limit']);
        $this->assertEquals(1199, $limits['remaining']);
        $this->assertEquals(60, $limits['reset']);
    }

    public function test_auth_exception_mapping()
    {
        $client = $this->createMockClient([
            new Response(401, [], json_encode([
                'success' => false,
                'errors' => [
                    [
                        'code' => 10000,
                        'message' => 'Authentication error',
                    ],
                ],
            ])),
        ]);

        $manager = new CloudflareManager($client);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Authentication error');

        $manager->zones()->all();
    }

    public function test_validation_exception_mapping()
    {
        $client = $this->createMockClient([
            new Response(422, [], json_encode([
                'success' => false,
                'errors' => [
                    [
                        'code' => 1004,
                        'message' => 'Validation failed',
                    ],
                ],
            ])),
        ]);

        $manager = new CloudflareManager($client);

        try {
            $manager->zones()->create(['name' => 'invalid-zone']);
            $this->fail('Expected ValidationException was not thrown');
        } catch (ValidationException $e) {
            $this->assertEquals('Validation failed', $e->getMessage());
            $this->assertEquals('1004', $e->getErrorCode());
            $this->assertCount(1, $e->getErrors());
            $this->assertEquals(1004, $e->getErrors()[0]['code']);
        }
    }

    public function test_network_exception_mapping()
    {
        $client = $this->createMockClient([
            new ConnectException('Connection timed out', new Request('GET', 'zones')),
        ], 0); // No retries

        $manager = new CloudflareManager($client);

        $this->expectException(NetworkException::class);
        $this->expectExceptionMessage('Connection timed out');

        $manager->zones()->all();
    }

    public function test_rate_limit_exception_mapping_and_retries()
    {
        $responseBody = json_encode([
            'success' => true,
            'result' => [['id' => 'zone1', 'name' => 'ghost-1.com', 'status' => 'active']],
        ]);

        // First call: 429 Too Many Requests
        // Second call: 200 OK
        $client = $this->createMockClient([
            new Response(429, [
                'Retry-After' => '1',
            ], json_encode([
                'success' => false,
                'errors' => [['code' => 1014, 'message' => 'Rate limit exceeded']],
            ])),
            new Response(200, [], $responseBody),
        ], 3, 0); // 3 retries, 0ms backoff multiplier for test speed

        $manager = new CloudflareManager($client);

        // Should retry once and succeed
        $zones = $manager->zones()->all();

        $this->assertCount(1, $zones);
        $this->assertEquals('ghost-1.com', $zones->first()->name);
    }

    public function test_async_requests()
    {
        $responseBody = json_encode([
            'success' => true,
            'result' => [['id' => 'zone1', 'name' => 'async-zone', 'status' => 'active']],
        ]);

        $client = $this->createMockClient([
            new Response(200, [], $responseBody),
        ]);

        $manager = new CloudflareManager($client);

        $promise = $manager->zones()->async()->all();

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        // Wait for resolution
        $zones = $promise->wait();

        $this->assertInstanceOf(ZoneCollection::class, $zones);
        $this->assertEquals('async-zone', $zones->first()->name);
    }

    public function test_batch_operations()
    {
        $responseBody1 = json_encode(['success' => true, 'result' => ['id' => 'zone1', 'name' => 'zone-1']]);
        $responseBody2 = json_encode(['success' => true, 'result' => ['id' => 'zone2', 'name' => 'zone-2']]);

        $client = $this->createMockClient([
            new Response(200, [], $responseBody1),
            new Response(200, [], $responseBody2),
        ]);

        $manager = new CloudflareManager($client);

        $results = $manager->batch([
            fn () => $manager->zones()->find('zone1'),
            fn () => $manager->zones()->find('zone2'),
        ]);

        $this->assertCount(2, $results);
        $this->assertInstanceOf(Zone::class, $results[0]);
        $this->assertInstanceOf(Zone::class, $results[1]);
        $this->assertEquals('zone-1', $results[0]->name);
        $this->assertEquals('zone-2', $results[1]->name);
    }
}
