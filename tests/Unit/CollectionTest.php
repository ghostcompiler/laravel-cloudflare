<?php

namespace Vendor\Cloudflare\Tests\Unit;

use Vendor\Cloudflare\Collections\ZoneCollection;
use Vendor\Cloudflare\Collections\AccountCollection;
use Vendor\Cloudflare\DTOs\Zone;
use Vendor\Cloudflare\DTOs\Account;
use Vendor\Cloudflare\Tests\TestCase;

class CollectionTest extends TestCase
{
    public function test_zone_collection()
    {
        $zone1 = Zone::fromArray(['id' => 'abc', 'name' => 'example.com']);
        $zone2 = Zone::fromArray(['id' => 'def', 'name' => 'example.org']);

        $col = new ZoneCollection([$zone1, $zone2]);

        $this->assertCount(2, $col);
        $this->assertEquals('example.com', $col->first()->name);
        $this->assertEquals('def', $col->last()->id);
    }

    public function test_account_collection()
    {
        $account = Account::fromArray(['id' => 'acc123', 'name' => 'My Account']);
        $col = new AccountCollection([$account]);

        $this->assertCount(1, $col);
        $this->assertEquals('My Account', $col->first()->name);
    }
}
