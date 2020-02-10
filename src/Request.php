<?php

namespace Ezdefi;

use Ezdefi\Exceptions\InvalidRequestMethodException;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

class Request
{
    /**
     * HTTP Client instance
     *
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * Request Factory instance
     *
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * Stream Factory instance
     *
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * Send request
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  bool  $body
     * @param  array  $headers
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     * @throws ClientExceptionInterface
     */
    public function sendRequest(string $method, string $uri, $body = false, $headers = [])
    {
        if(!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new InvalidRequestMethodException('Wrong request method. Only supports GET, POST, PUT, DELETE');
        }

        $response = $this->getHttpClient()->sendRequest(
            $this->createRequest($method, $uri, $body, $headers)
        );

        return $this->handleResponse($response);
    }

    /**
     * Create request
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  bool  $body
     * @param  array  $headers
     *
     * @return RequestInterface
     */
    protected function createRequest(string $method, string $uri, $body = false, $headers = []): RequestInterface
    {
        $request = $this->getRequestFactory()->createRequest($method, $uri);

        if($body) {
            $stream = $this->getStreamFactory()->createStream(json_encode($body));
            $request = $request->withBody($stream);
        }

        foreach($headers as $name => $header) {
            $request = $request->withAddedHeader($name, $header);
        }

        return $request;
    }

    /**
     * Get HTTP Client
     *
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        if(is_null($this->httpClient)) {
            $this->httpClient = new PluginClient(
                Psr18ClientDiscovery::find(),
                [new ErrorPlugin()]
            );
        }

        return $this->httpClient;
    }

    /**
     * Set HTTP Client
     *
     * @param  ClientInterface  $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get Request Factory
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        if(is_null($this->requestFactory)) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    /**
     * Set Request Factory
     *
     * @param  RequestFactoryInterface  $requestFactory
     */
    public function setRequestFactory(RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * Get Stream Factory
     *
     * @return StreamFactoryInterface
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        if(is_null($this->streamFactory)) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }

    /**
     * Set Stream Factory
     *
     * @param  StreamFactoryInterface  $streamFactory
     */
    public function setStreamFactory(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * Handle response from API
     *
     * @param  ResponseInterface  $response
     *
     * @return mixed
     */
    protected function handleResponse(ResponseInterface $response)
    {
        $response = $response->getBody()->getContents();

        return json_decode($response, true);
    }
}