<?php

namespace Vendor\Cloudflare\Http\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Vendor\Cloudflare\Exceptions\ApiException;
use Vendor\Cloudflare\Exceptions\AuthenticationException;
use Vendor\Cloudflare\Exceptions\AuthorizationException;
use Vendor\Cloudflare\Exceptions\CloudflareException;
use Vendor\Cloudflare\Exceptions\NetworkException;
use Vendor\Cloudflare\Exceptions\NotFoundException;
use Vendor\Cloudflare\Exceptions\RateLimitException;
use Vendor\Cloudflare\Exceptions\ServerException;
use Vendor\Cloudflare\Exceptions\ValidationException;
use Vendor\Cloudflare\Http\Middleware\RetryMiddleware;

class CloudflareClient
{
    private string $token;

    private string $email;

    private string $apiKey;

    private string $baseUrl;

    private int $timeout;

    private int $maxRetries;

    private int $retryBackoff;

    private bool $loggingEnabled;

    private ?string $loggingChannel;

    private ?GuzzleClient $guzzleClient = null;

    private array $requestHooks = [];

    private array $responseHooks = [];

    private bool $async = false;

    private ?array $batchQueue = null;

    private array $lastRateLimit = [
        'limit' => null,
        'remaining' => null,
        'reset' => null,
    ];

    public function __construct(string $token = '', string $email = '', string $apiKey = '', array $config = [])
    {
        $this->token = $token ?: ($config['token'] ?? '');
        $this->email = $email ?: ($config['email'] ?? '');
        $this->apiKey = $apiKey ?: ($config['api_key'] ?? '');
        
        $this->baseUrl = $config['base_url'] ?? 'https://api.cloudflare.com/client/v4';
        $this->timeout = (int) ($config['timeout'] ?? 30);
        $this->maxRetries = (int) ($config['retries'] ?? 3);
        $this->retryBackoff = (int) ($config['retry_backoff'] ?? 100);
        $this->loggingEnabled = (bool) ($config['logging']['enabled'] ?? false);
        $this->loggingChannel = $config['logging']['channel'] ?? null;
    }

    public function setGuzzleClient(GuzzleClient $client): self
    {
        $this->guzzleClient = $client;

        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        $this->guzzleClient = null; // Rebuild client

        return $this;
    }

    public function setAuthKey(string $email, string $apiKey): self
    {
        $this->email = $email;
        $this->apiKey = $apiKey;
        $this->token = ''; // Clear token if global key is explicitly set
        $this->guzzleClient = null; // Rebuild client

        return $this;
    }

    public function authenticate(string $tokenOrEmail, ?string $apiKey = null): self
    {
        if ($apiKey !== null) {
            return $this->setAuthKey($tokenOrEmail, $apiKey);
        }

        return $this->setToken($tokenOrEmail);
    }

    public function setAsync(bool $async): self
    {
        $this->async = $async;

        return $this;
    }

    public function startBatch(): void
    {
        $this->batchQueue = [];
    }

    /**
     * @return PromiseInterface[]|null
     */
    public function endBatch(): ?array
    {
        $queue = $this->batchQueue;
        $this->batchQueue = null;

        return $queue;
    }

    public function isBatching(): bool
    {
        return $this->batchQueue !== null;
    }

    public function addRequestHook(callable $hook): self
    {
        $this->requestHooks[] = $hook;

        return $this;
    }

    public function addResponseHook(callable $hook): self
    {
        $this->responseHooks[] = $hook;

        return $this;
    }

    public function getLastRateLimit(): array
    {
        return $this->lastRateLimit;
    }

    /**
     * Send HTTP Request.
     *
     * @return mixed Response array, DTO, or PromiseInterface
     *
     * @throws CloudflareException
     */
    public function request(string $method, string $uri, array $options = [])
    {
        if ($this->async || $this->isBatching()) {
            $promise = $this->requestAsync($method, $uri, $options);
            if ($this->isBatching()) {
                $this->batchQueue[] = $promise;
            }
            // Reset async mode
            $this->async = false;

            return $promise;
        }

        try {
            $response = $this->getGuzzleClient()->request($method, $uri, $options);
            $this->updateRateLimit($response);

            return $this->decodeResponse($response);
        } catch (\Throwable $e) {
            throw $this->mapException($e);
        }
    }

    /**
     * Send HTTP Request asynchronously.
     */
    public function requestAsync(string $method, string $uri, array $options = []): PromiseInterface
    {
        $promise = $this->getGuzzleClient()->requestAsync($method, $uri, $options);

        return $promise->then(
            function (ResponseInterface $response) {
                $this->updateRateLimit($response);

                return $this->decodeResponse($response);
            },
            function (\Throwable $reason) {
                throw $this->mapException($reason);
            }
        );
    }

    private function getGuzzleClient(): GuzzleClient
    {
        if ($this->guzzleClient === null) {
            $this->guzzleClient = $this->buildGuzzleClient();
        }

        return $this->guzzleClient;
    }

    private function buildGuzzleClient(): GuzzleClient
    {
        $stack = HandlerStack::create();

        // Add retry & backoff middleware
        $retry = new RetryMiddleware($this->maxRetries, $this->retryBackoff);
        $stack->push(Middleware::retry($retry->decider(), $retry->delay()));

        // Add custom request hooks middleware
        $stack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                foreach ($this->requestHooks as $hook) {
                    $request = $hook($request) ?: $request;
                }

                return $handler($request, $options);
            };
        });

        // Add custom response hooks middleware
        $stack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                return $handler($request, $options)->then(function (ResponseInterface $response) {
                    foreach ($this->responseHooks as $hook) {
                        $response = $hook($response) ?: $response;
                    }

                    return $response;
                });
            };
        });

        // Add logging middleware if enabled
        if ($this->loggingEnabled) {
            $stack->push(function (callable $handler) {
                return function (RequestInterface $request, array $options) use ($handler) {
                    $this->logRequest($request);

                    return $handler($request, $options)->then(
                        function (ResponseInterface $response) {
                            $this->logResponse($response);

                            return $response;
                        },
                        function (\Throwable $reason) {
                            $this->logError($reason);
                            throw $reason;
                        }
                    );
                };
            });
        }

        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'laravel-cloudflare/1.0.0',
        ];

        if ($this->token !== '') {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        } elseif ($this->apiKey !== '' && $this->email !== '') {
            $headers['X-Auth-Email'] = $this->email;
            $headers['X-Auth-Key'] = $this->apiKey;
        }

        return new GuzzleClient([
            'base_uri' => rtrim($this->baseUrl, '/').'/',
            'headers' => $headers,
            'timeout' => $this->timeout,
            'handler' => $stack,
        ]);
    }

    private function updateRateLimit(ResponseInterface $response): void
    {
        $limit = $response->getHeaderLine('X-RateLimit-Limit') ?: $response->getHeaderLine('RateLimit-Limit');
        $remaining = $response->getHeaderLine('X-RateLimit-Remaining') ?: $response->getHeaderLine('RateLimit-Remaining');
        $reset = $response->getHeaderLine('X-RateLimit-Reset') ?: $response->getHeaderLine('RateLimit-Reset');

        if ($limit !== '') {
            $this->lastRateLimit['limit'] = (int) $limit;
        }
        if ($remaining !== '') {
            $this->lastRateLimit['remaining'] = (int) $remaining;
        }
        if ($reset !== '') {
            $this->lastRateLimit['reset'] = (int) $reset;
        }
    }

    /**
     * Decode JSON response body.
     */
    private function decodeResponse(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        if ($body === '') {
            return [];
        }

        $decoded = json_decode($body, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Map Guzzle Exceptions to Cloudflare Custom Exceptions.
     */
    public function mapException(\Throwable $e): CloudflareException
    {
        if ($e instanceof CloudflareException) {
            return $e;
        }

        if ($e instanceof ConnectException) {
            return new NetworkException('Connection error: '.$e->getMessage(), 0, $e);
        }

        if ($e instanceof RequestException && $e->getResponse() !== null) {
            $response = $e->getResponse();
            $status = $response->getStatusCode();
            $body = $this->decodeResponse($response);
            
            // Cloudflare standard error responses
            $errors = $body['errors'] ?? [];
            $firstError = $errors[0] ?? [];
            
            $message = $firstError['message'] ?? $e->getMessage();
            $errorCode = (string) ($firstError['code'] ?? '');
            $details = $errors;

            switch ($status) {
                case 401:
                    return new AuthenticationException($message, $status, $errorCode, $details, $e);
                case 403:
                    return new AuthorizationException($message, $status, $errorCode, $details, $e);
                case 404:
                    return new NotFoundException($message, $status, $errorCode, $details, $e);
                case 422:
                    return new ValidationException($message, $status, $errorCode, $details, $e);
                case 429:
                    $limit = $response->getHeaderLine('X-RateLimit-Limit') ?: $response->getHeaderLine('RateLimit-Limit');
                    $remaining = $response->getHeaderLine('X-RateLimit-Remaining') ?: $response->getHeaderLine('RateLimit-Remaining');
                    $reset = $response->getHeaderLine('X-RateLimit-Reset') ?: $response->getHeaderLine('RateLimit-Reset');

                    return new RateLimitException(
                        $message,
                        $status,
                        $errorCode,
                        $details,
                        $limit !== '' ? (int) $limit : null,
                        $remaining !== '' ? (int) $remaining : null,
                        $reset !== '' ? (int) $reset : null,
                        $e
                    );
                default:
                    if ($status >= 500 && $status <= 599) {
                        return new ServerException($message, $status, $errorCode, $details, $e);
                    }

                    return new ApiException($message, $status, $errorCode, $details, $e);
            }
        }

        return new CloudflareException('An unexpected error occurred: '.$e->getMessage(), 0, $e);
    }

    private function logRequest(RequestInterface $request): void
    {
        $message = sprintf(
            'Cloudflare API Request: %s %s',
            $request->getMethod(),
            $request->getUri()
        );
        $this->log('info', $message, [
            'headers' => $request->getHeaders(),
            'body' => (string) $request->getBody(),
        ]);
    }

    private function logResponse(ResponseInterface $response): void
    {
        $message = sprintf(
            'Cloudflare API Response: %d',
            $response->getStatusCode()
        );
        $this->log('info', $message, [
            'headers' => $response->getHeaders(),
            'body' => (string) $response->getBody(),
        ]);
    }

    private function logError(\Throwable $e): void
    {
        $message = sprintf(
            'Cloudflare API Error: %s',
            $e->getMessage()
        );
        $this->log('error', $message, [
            'exception' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    private function log(string $level, string $message, array $context = []): void
    {
        if (class_exists(Log::class)) {
            if ($this->loggingChannel) {
                Log::channel($this->loggingChannel)->$level($message, $context);
            } else {
                Log::$level($message, $context);
            }
        }
    }
}
