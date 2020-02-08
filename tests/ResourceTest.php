<?php

namespace Ezdefi\Tests;

use Ezdefi\Client;
use Ezdefi\Exceptions\InvalidRequestMethodException;
use Ezdefi\Request;
use Ezdefi\Resource;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResourceTest extends TestCase
{
    protected $client;

    protected $request;

    protected $resource;

    protected function setUp()
    {
        $this->client = new Client('fake-api-key', 'http://foo.bar');
        $this->request = $this->getMockBuilder(Request::class)->getMock();
        $this->resource = new Resource($this->client, $this->request);
    }

    public function testAddRequestHeaders()
    {
        $expected = [
            'foo' => 'bar',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'api-key' => 'fake-api-key'
        ];

        $actual = $this->resource->addRequestHeaders([
            'foo' => 'bar'
        ]);

        $this->assertEquals($expected, $actual);
    }

    public function testBuildPath()
    {
        $expected = 'http://foo.bar/token';

        $this->client->setBaseUrl('http://foo.bar');
        $actual = $this->resource->buildPath('token');
        $this->assertEquals($expected, $actual);

        $this->client->setBaseUrl('http://foo.bar/');
        $actual = $this->resource->buildPath('token');
        $this->assertEquals($expected, $actual);

        $this->client->setBaseUrl('http://foo.bar');
        $actual = $this->resource->buildPath('/token');
        $this->assertEquals($expected, $actual);
    }

    public function testCall()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'api-key' => 'fake-api-key'
        ];

        $expected = [
            'code' => 1,
            'data' => 'data'
        ];

        $parameters = [
            'foo' => 'bar'
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('POST', 'http://foo.bar/token', $parameters, $headers)
                      ->willReturn($expected);

        $actual = $this->resource->call('POST', 'token', $parameters, []);

        $this->assertEquals($expected, $actual);
    }

    public function testCallWithInvalidMethodThrowException()
    {
        try {
            $this->resource->call('WRONG', '/', [], []);
            $this->fail('Expected exception not thrown');
        } catch (InvalidRequestMethodException $e) {
            $this->assertEquals('Wrong request method. Only supports GET, POST, PUT, DELETE', $e->getMessage());
        }
    }

    public function testCallWithQueryParameters()
    {
        $headers = [
            'foo' => 'bar',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'api-key' => 'fake-api-key'
        ];

        $expected = [
            'code' => 1,
            'data' => 'data'
        ];

        $parameters = [
            'id' => '1',
            'limit' => '5'
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token?id=1&limit=5', false, $headers)
                      ->willReturn($expected);

        $actual = $this->resource->call('GET', 'token', $parameters, ['foo' => 'bar']);

        $this->assertEquals($expected, $actual);
    }

    public function testGet()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $mockHttpClient = $this->createMockHttpClient($expected);

        $request = new Request();
        $request->setHttpClient($mockHttpClient);
        $resource = new Resource($this->client, $request);

        $actual = $resource->get('token/list');

        $request = $mockHttpClient->getLastRequest();
        $requestHeaders = $request->getHeaders();
        $requestUri = $request->getUri();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('foo.bar', $requestUri->getHost());
        $this->assertEquals('/token/list', $requestUri->getPath());
        $this->assertEquals('application/json', $requestHeaders['Accept'][0]);
        $this->assertEquals('application/json', $requestHeaders['Content-Type'][0]);
        $this->assertEquals('fake-api-key', $requestHeaders['api-key'][0]);
    }

    public function testGetWithQueryParams()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $parameters = [
            'id' => 1,
            'limit' => 5
        ];

        $mockHttpClient = $this->createMockHttpClient($expected);

        $request = new Request();
        $request->setHttpClient($mockHttpClient);
        $resource = new Resource($this->client, $request);

        $actual = $resource->get('token/list', $parameters);

        $request = $mockHttpClient->getLastRequest();
        $requestUri = $request->getUri();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('id=1&limit=5', $requestUri->getQuery());
    }

    public function testPost()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $data = [
            'data' => 'data'
        ];

        $mockHttpClient = $this->createMockHttpClient($expected);

        $request = new Request();
        $request->setHttpClient($mockHttpClient);
        $resource = new Resource($this->client, $request);

        $actual = $resource->post('payment/create', $data);

        $request = $mockHttpClient->getLastRequest();
        $requestHeaders = $request->getHeaders();
        $requestUri = $request->getUri();
        $requestBody = $request->getBody();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('foo.bar', $requestUri->getHost());
        $this->assertEquals('/payment/create', $requestUri->getPath());
        $this->assertEquals('application/json', $requestHeaders['Accept'][0]);
        $this->assertEquals('application/json', $requestHeaders['Content-Type'][0]);
        $this->assertEquals('fake-api-key', $requestHeaders['api-key'][0]);
        $this->assertEquals(json_encode($data), $requestBody->__toString());
    }

    protected function createMockHttpClient(array $expected)
    {
        $mockHttpClient = new MockClient();

        $stream = $this->getMockBuilder(StreamInterface::class)->getMock();
        $stream->expects($this->once())->method('getContents')->willReturn(json_encode($expected));
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects($this->once())->method('getBody')->willReturn($stream);

        $mockHttpClient->addResponse($response);

        return $mockHttpClient;
    }
}