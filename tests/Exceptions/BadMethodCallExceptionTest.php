<?php

namespace Hedii\ZoteroApi\Tests\Exceptions;

use Hedii\ZoteroApi\Exceptions\BadMethodCallException;
use Hedii\ZoteroApi\Tests\TestCase;

class BadMethodCallExceptionTest extends TestCase
{
    public function testRawAfterOtherMethodsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group(12345)
            ->raw('groups/' . $this->groupId . '/items');
    }

    public function testItemWithoutUserOrGroupThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api->items();
    }

    public function testTrashWithoutItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->trash();
    }

    public function testChildrenWithoutItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->children();
    }

    public function testChildrenWithoutItemKeyThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->items()
            ->children();
    }

    public function testTagsWithoutUserOrGroupThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api->tags();
    }

    public function testTagsAfterItemsWithoutKeyThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->items()
            ->tags();
    }

    public function testTagsAfterCollectionsWithoutKeyThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->collections()
            ->tags();
    }

    public function testTagsWithTagAfterItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->items()
            ->tags('a tag');
    }

    public function testTagsWithTagAfterCollectionsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group($this->groupId)
            ->collections()
            ->tags('a tag');
    }

    public function testCollectionsWithoutUserOrGroupThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api->collections();
    }

    public function testSubCollectionsAfterItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->items()
            ->subCollections();
    }

    public function testSubCollectionsAfterUserThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->subCollections();
    }

    public function testSubCollectionsAfterGroupThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->group(12345)
            ->subCollections();
    }

    public function testSearchesAfterItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->items()
            ->searches();
    }

    public function testSearchesAfterCollectionsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->collections()
            ->searches();
    }

    public function testGroupsAfterItemsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->items()
            ->groups();
    }

    public function testGroupsAfterCollectionsThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->collections()
            ->groups();
    }

    public function testVersionsAfterItemWithKeyThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->items(12345)
            ->versions();
    }

    public function testVersionsAfterCollectionWithKeyThrowsAnException()
    {
        $this->expectException(BadMethodCallException::class);

        $this->api
            ->user(12345)
            ->collections(12345)
            ->versions();
    }
}