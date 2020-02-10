<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Client;
use Ezdefi\Request;
use Ezdefi\Resource;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BaseResourceTestCase extends TestCase
{
    protected $client;

    protected $request;

    protected function setUp()
    {
        $this->client = new Client('fake-api-key');
        $this->client->setBaseUrl('http://foo.bar');
        $this->request = $this->getMockBuilder(Request::class)->getMock();
    }
}