<?php

namespace Vendor\Cloudflare\Tests\Unit;

use Vendor\Cloudflare\DTOs\Account;
use Vendor\Cloudflare\DTOs\DnsRecord;
use Vendor\Cloudflare\DTOs\PaginationMeta;
use Vendor\Cloudflare\DTOs\Zone;
use Vendor\Cloudflare\Tests\TestCase;

class DTOTest extends TestCase
{
    public function test_account_dto()
    {
        $data = [
            'id' => 'acc_123',
            'name' => 'Ghost Account',
            'settings' => ['enforce_twofactor' => true]
        ];

        $dto = Account::fromArray($data);

        $this->assertEquals('acc_123', $dto->id);
        $this->assertEquals('Ghost Account', $dto->name);
        $this->assertEquals(['enforce_twofactor' => true], $dto->settings);
    }

    public function test_zone_dto()
    {
        $data = [
            'id' => 'zone_456',
            'name' => 'ghost.com',
            'status' => 'active',
            'paused' => false,
            'type' => 'full',
            'development_mode' => 0,
            'name_servers' => ['ns1.cloudflare.com', 'ns2.cloudflare.com']
        ];

        $dto = Zone::fromArray($data);

        $this->assertEquals('zone_456', $dto->id);
        $this->assertEquals('ghost.com', $dto->name);
        $this->assertEquals('active', $dto->status);
        $this->assertFalse($dto->paused);
        $this->assertEquals(['ns1.cloudflare.com', 'ns2.cloudflare.com'], $dto->name_servers);
    }

    public function test_dns_record_dto()
    {
        $data = [
            'id' => 'dns_789',
            'zone_id' => 'zone_456',
            'name' => 'www.ghost.com',
            'type' => 'A',
            'content' => '1.2.3.4',
            'proxied' => true,
            'ttl' => 1
        ];

        $dto = DnsRecord::fromArray($data);

        $this->assertEquals('dns_789', $dto->id);
        $this->assertEquals('zone_456', $dto->zone_id);
        $this->assertEquals('www.ghost.com', $dto->name);
        $this->assertEquals('A', $dto->type);
        $this->assertEquals('1.2.3.4', $dto->content);
        $this->assertTrue($dto->proxied);
        $this->assertEquals(1, $dto->ttl);
    }

    public function test_pagination_meta_dto()
    {
        $data = [
            'page' => 2,
            'per_page' => 20,
            'previous_page' => 1,
            'next_page' => 3,
            'last_page' => 5,
            'total_entries' => 95
        ];

        $dto = PaginationMeta::fromArray($data);

        $this->assertEquals(2, $dto->page);
        $this->assertEquals(20, $dto->perPage);
        $this->assertEquals(1, $dto->previousPage);
        $this->assertEquals(3, $dto->nextPage);
        $this->assertEquals(5, $dto->lastPage);
        $this->assertEquals(95, $dto->totalEntries);
    }
}
