<?php

namespace Ezdefi\Tests;

use Ezdefi\Client;
use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Exceptions\InvalidResourceException;
use Ezdefi\Request;
use Ezdefi\Resources\Token;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new Client('fake-api-key', 'http://foo.bar');
    }

    public function testCreateInstanceWithEmptyApiKey()
    {
        try {
            new Client('', 'http://foo.bar');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('API key is required', $e->getMessage());
        }
    }

    public function testCreateInstanceWithEmptyBaseUrl()
    {
        try {
            new Client('fake-api-key', '');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('Base URL is required', $e->getMessage());
        }
    }

    public function testCreateInstanceWithInvalidBaseUrl()
    {
        try {
            new Client('fake-api-key', 'foo.bar');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('Base URL is not valid', $e->getMessage());
        }
    }

    public function testGetResource()
    {
        $token = $this->client->token;

        $this->assertInstanceOf(Token::class, $token);
    }

    public function testGetResourceThrowExceptionIfNotExist()
    {
        try {
            $nonExist = $this->client->nonExist;
            $this->fail('Expected exception not thrown');
        } catch (InvalidResourceException $e) {
            $this->assertEquals('NonExist resource not exist', $e->getMessage());
        }
    }

    public function testGetApiKey()
    {
        $this->assertEquals('fake-api-key', $this->client->getApiKey());
    }

    public function testSetApiKey()
    {
        $this->client->setApiKey('new-api-key');

        $this->assertEquals('new-api-key', $this->client->getApiKey());
    }

    public function testGetBaseUrl()
    {
        $this->assertEquals('http://foo.bar', $this->client->getBaseUrl());
    }

    public function testSetBaseUrl()
    {
        $this->client->setBaseUrl('http://bar.foo');

        $this->assertEquals('http://bar.foo', $this->client->getBaseUrl());
    }
}