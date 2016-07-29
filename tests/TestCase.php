<?php

namespace Hedii\ZoteroApi\Tests;

use Hedii\ZoteroApi\ZoteroApi;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $groupId;

    /**
     * @var \Hedii\ZoteroApi\ZoteroApi
     */
    public $api;

    public function setUp()
    {
        $this->apiKey = getenv('ZOTERO_API_KEY');
        $this->userId = getenv('ZOTERO_USER_ID');
        $this->groupId = getenv('ZOTERO_GROUP_ID');
        $this->api = new ZoteroApi($this->apiKey);
    }
}