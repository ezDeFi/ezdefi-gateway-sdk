<?php

namespace Ezdefi\Tests;

use Ezdefi\Request;
use Ezdefi\Tests\Fixtures\RequestFactoryTestStub;
use Ezdefi\Tests\Fixtures\StreamFactoryTestStub;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class RequestTest extends TestCase
{
    protected $request;

    protected $mockHttpClient;

    protected $requestFactory;

    protected $streamFactory;

    protected function setUp()
    {
        $this->request = new Request();

        $this->mockHttpClient = new MockClient();

        $this->request->setHttpClient($this->mockHttpClient);
    }

    public function testGetHttpClient()
    {
        $httpClient = $this->request->getHttpClient();

        $this->assertInstanceOf(ClientInterface::class, $httpClient);
    }

    public function testSendRequest()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $this->setMockHttpClient($expected);

        $actual = $this->request->sendRequest('GET', 'http://foo.bar');

        $request = $this->mockHttpClient->getLastRequest();
        $requestHeaders = $request->getHeaders();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('foo.bar', $requestHeaders['Host'][0]);
    }

    public function testSendWithHeaders()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $this->setMockHttpClient($expected);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $actual = $this->request->sendRequest('POST', 'http://foo.bar', false, $headers);

        $request = $this->mockHttpClient->getLastRequest();
        $requestHeaders = $request->getHeaders();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('application/json', $requestHeaders['Accept'][0]);
        $this->assertEquals('application/json', $requestHeaders['Content-Type'][0]);
    }

    public function testSendRequestWithBody()
    {
        $expected = [
            'foo' => 'bar'
        ];

        $this->setMockHttpClient($expected);

        $body = [
            'foo' => 'bar'
        ];

        $actual = $this->request->sendRequest('POST', 'http://foo.bar', $body);

        $request = $this->mockHttpClient->getLastRequest();
        $requestBody = $request->getBody();

        $this->assertEquals($expected, $actual);
        $this->assertEquals('{"foo":"bar"}', $requestBody->__toString());
    }

    public function testGetRequestFactory()
    {
        $this->assertInstanceOf(RequestFactoryInterface::class, $this->request->getRequestFactory());
    }

    public function testSetRequestFactory()
    {
        $requestFactory = new RequestFactoryTestStub();

        $this->request->setRequestFactory($requestFactory);

        $this->assertInstanceOf(RequestFactoryTestStub::class, $this->request->getRequestFactory());
    }

    public function testGetStreamFactory()
    {
        $this->assertInstanceOf(StreamFactoryInterface::class, $this->request->getStreamFactory());
    }

    public function testSetStreamFactory()
    {
        $streamFactory = new StreamFactoryTestStub();

        $this->request->setStreamFactory($streamFactory);

        $this->assertInstanceOf(StreamFactoryTestStub::class, $this->request->getStreamFactory());
    }

    protected function setMockHttpClient($expectedResponse)
    {
        $stream = $this->getMockBuilder(StreamInterface::class)->getMock();
        $stream->expects($this->once())->method('getContents')->willReturn(json_encode($expectedResponse));
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects($this->once())->method('getBody')->willReturn($stream);

        $this->mockHttpClient->addResponse($response);
    }
}