<?php

namespace Hedii\ZoteroApi\Tests;

class ConfigurationTest extends TestCase
{
    public function testZoteroApiKey()
    {
        $this->assertNotNull(getenv('ZOTERO_API_KEY'));
        $this->assertTrue(is_string(getenv('ZOTERO_API_KEY')));
    }

    public function testZoteroUserId()
    {
        $this->assertNotNull(getenv('ZOTERO_USER_ID'));
        $this->assertTrue(is_numeric(getenv('ZOTERO_USER_ID')));
    }

    public function testZoteroGroupId()
    {
        $this->assertNotNull(getenv('ZOTERO_GROUP_ID'));
        $this->assertTrue(is_numeric(getenv('ZOTERO_GROUP_ID')));
    }
}
