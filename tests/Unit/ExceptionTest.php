<?php

namespace Vendor\Cloudflare\Tests\Unit;

use Vendor\Cloudflare\Exceptions\ApiException;
use Vendor\Cloudflare\Exceptions\RateLimitException;
use Vendor\Cloudflare\Exceptions\ValidationException;
use Vendor\Cloudflare\Tests\TestCase;

class ExceptionTest extends TestCase
{
    public function test_api_exception_properties()
    {
        $e = new ApiException('Error message', 400, 'bad_request', ['some' => 'detail']);

        $this->assertEquals('Error message', $e->getMessage());
        $this->assertEquals(400, $e->getCode());
        $this->assertEquals('bad_request', $e->getErrorCode());
        $this->assertEquals(['some' => 'detail'], $e->getErrorDetails());
    }

    public function test_validation_exception_parsing()
    {
        $details = [
            ['code' => 10001, 'message' => 'invalid zone name']
        ];

        $e = new ValidationException('Unprocessable Entity', 422, 'invalid_input', $details);

        $errors = $e->getErrors();

        $this->assertCount(1, $errors);
        $this->assertEquals(10001, $errors[0]['code']);
    }

    public function test_rate_limit_exception_properties()
    {
        $e = new RateLimitException(
            'Too many requests',
            429,
            'rate_limit_exceeded',
            [],
            1200,
            0,
            time() + 60
        );

        $this->assertEquals(1200, $e->getLimit());
        $this->assertEquals(0, $e->getRemaining());
        $this->assertGreaterThan(time(), $e->getResetTimestamp());
        $this->assertGreaterThanOrEqual(58, $e->getSecondsUntilReset());
    }
}
