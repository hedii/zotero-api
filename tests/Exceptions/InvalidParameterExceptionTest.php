<?php

namespace Hedii\ZoteroApi\Tests\Exceptions;

use Hedii\ZoteroApi\Exceptions\InvalidParameterException;
use Hedii\ZoteroApi\Tests\TestCase;

class InvalidParameterExceptionTest extends TestCase
{
    public function testTagsWithInvalidArgumentThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);

        $this->api
            ->tags(12345);
    }

    public function testSortByWithInvalidArgumentThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);

        $this->api
            ->sortBy('something');
    }

    public function testDirectionWithInvalidArgumentThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);

        $this->api
            ->direction('something');
    }

    public function testLimitWithInvalidArgumentThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);

        $this->api
            ->limit('something');
    }

    public function testStartWithInvalidArgumentThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);
        $this->api
            ->start('something');
    }

    public function testItemsWithAnArrayOfMoreThanFiftyKeysThrowsAnException()
    {
        $this->expectException(InvalidParameterException::class);

        $keys = [];

        for ($i = 0; $i < 51; $i++) {
            $keys[] = (string) $i;
        }

        $this->api
            ->group(12345)
            ->items($keys);
    }
}