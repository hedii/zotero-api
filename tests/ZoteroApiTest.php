<?php

namespace Hedii\ZoteroApi\Tests;

use GuzzleHttp\Client;
use Hedii\ZoteroApi\ZoteroApi;

class ZoteroApiTest extends TestCase
{
    public function testZoteroApiClassExists()
    {
        $this->assertInstanceOf(ZoteroApi::class, $this->api);
    }

    public function testGetVersion()
    {
        $version = $this->api->getVersion();

        $this->assertTrue(is_int($version));
    }

    public function testSetVersion()
    {
        $version = $this->api->getVersion();
        $newVersion = 2;

        $result = $this->api->setVersion($newVersion);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertNotEquals($version, $this->api->getVersion());
        $this->assertEquals($newVersion, $this->api->getVersion());
    }

    public function testGetTimeout()
    {
        $timeout = $this->api->getTimeout();

        $this->assertEquals(0, $timeout);
    }

    public function testSetTimeout()
    {
        $result = $this->api->setTimeout(3.12);
        $timeout = $this->api->getTimeout();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(3.12, $timeout);
    }

    public function testGetConnectionTimeout()
    {
        $timeout = $this->api->getConnectionTimeout();

        $this->assertEquals(0, $timeout);
    }

    public function testSetConnectionTimeout()
    {
        $result = $this->api->setConnectionTimeout(3.12);
        $timeout = $this->api->getConnectionTimeout();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(3.12, $timeout);
    }

    public function testGetDelay()
    {
        $delay = $this->api->getDelay();

        $this->assertEquals(0, $delay);
    }

    public function testSetDelay()
    {
        $result = $this->api->setDelay(3);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(3, $this->api->getDelay());
    }

    public function testGetPath()
    {
        $result = $this->api->getPath();

        $this->assertEquals(null, $result);
    }

    public function testSetPath()
    {
        $result = $this->api->setPath('something');

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals('something', $this->api->getPath());
    }

    public function testGetClient()
    {
        $result = $this->api->getClient();

        $this->assertInstanceOf(Client::class, $result);
    }

    public function testRaw()
    {
        $result = $this->api
            ->raw('users/' . $this->userId . '/items');

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/' . $this->userId . '/items',
            $this->api->getPath()
        );
    }

    public function testUser()
    {
        $result = $this->api->user(12345);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals('users/12345', $this->api->getPath());
    }

    public function testGroup()
    {
        $result = $this->api->group(12345);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals('groups/12345', $this->api->getPath());
    }

    public function testItem()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items',
            $this->api->getPath()
        );
    }

    public function testItemWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items(12345);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items/12345',
            $this->api->getPath()
        );
    }

    public function testItemsAfterCollections()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections(12345)
            ->items();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections/12345/items',
            $this->api->getPath()
        );
    }

    public function testTopAfterItems()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items()
            ->top();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items/top',
            $this->api->getPath()
        );
    }

    public function testTopAfterCollectionsItemsWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections(12345)
            ->items()
            ->top();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections/12345/items/top',
            $this->api->getPath()
        );
    }

    public function testTrash()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items()
            ->trash();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items/trash',
            $this->api->getPath()
        );
    }

    public function testChildren()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items(12345)
            ->children();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items/12345/children',
            $this->api->getPath()
        );
    }

    public function testTags()
    {
        $result = $this->api
            ->group($this->groupId)
            ->tags();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/tags',
            $this->api->getPath()
        );
    }

    public function testTagsWithTag()
    {
        $result = $this->api
            ->group($this->groupId)
            ->tags('a string');

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/tags/' . rawurlencode('a string'),
            $this->api->getPath()
        );
    }

    public function testTagsAfterItemsWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->items(12345)
            ->tags();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/items/12345/tags',
            $this->api->getPath()
        );
    }

    public function testTagsAfterCollectionsWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections(12345)
            ->tags();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections/12345/tags',
            $this->api->getPath()
        );
    }

    public function testCollections()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections',
            $this->api->getPath()
        );
    }

    public function testCollectionsWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections(12345);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections/12345',
            $this->api->getPath()
        );
    }

    public function testSubCollection()
    {
        $result = $this->api
            ->group($this->groupId)
            ->collections(12345)
            ->subCollections();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/collections/12345/collections',
            $this->api->getPath()
        );
    }

    public function testSearches()
    {
        $result = $this->api
            ->group($this->groupId)
            ->searches();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/searches',
            $this->api->getPath()
        );
    }

    public function testSearchesWithKey()
    {
        $result = $this->api
            ->group($this->groupId)
            ->searches(12345);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'groups/' . $this->groupId . '/searches/12345',
            $this->api->getPath()
        );
    }

    public function testKey()
    {
        $result = $this->api
            ->key($this->apiKey);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals('keys/' . $this->apiKey, $this->api->getPath());
    }

    public function testGroups()
    {
        $result = $this->api
            ->user(12345)
            ->groups();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals('users/12345/groups', $this->api->getPath());
    }

    public function testSortBy()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->sortBy('dateAdded');

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?sort=dateAdded',
            $this->api->getPath()
        );
    }

    public function testDirection()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->direction('desc');

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?direction=desc',
            $this->api->getPath()
        );
    }

    public function testLimit()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->limit(6);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?limit=6',
            $this->api->getPath()
        );
    }

    public function testStart()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->start(3);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?start=3',
            $this->api->getPath()
        );
    }

    public function testSortingAndPaginationAllTogether()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->sortBy('dateAdded')
            ->direction('asc')
            ->limit(20)
            ->start(3);

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?sort=dateAdded&direction=asc&limit=20&start=3',
            $this->api->getPath()
        );
    }

    public function testVersions()
    {
        $result = $this->api
            ->user(12345)
            ->items()
            ->versions();

        $this->assertInstanceOf(ZoteroApi::class, $result);
        $this->assertEquals(
            'users/12345/items?format=versions',
            $this->api->getPath()
        );
    }
}
