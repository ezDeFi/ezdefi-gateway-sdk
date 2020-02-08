<?php

namespace Ezdefi;

use Ezdefi\Exceptions\InvalidRequestMethodException;

class Resource
{
    /**
     * Client instance
     *
     * @var Client
     */
    protected $client;

    /**
     * Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * Resource constructor.
     *
     * @param  Client  $client
     * @param  Request  $request
     */
    public function __construct(Client $client, Request $request)
    {
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * Send GET request
     *
     * @param  string  $endpoint
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function get(string $endpoint, array $parameters = [])
    {
        return $this->call('GET', $endpoint, $parameters, []);
    }

    /**
     * Send POST request
     *
     * @param  string  $endpoint
     * @param  array  $data
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function post(string $endpoint, array $data = [])
    {
        return $this->call('POST', $endpoint, $data, []);
    }

    /**
     * Send request
     *
     * @param  string  $method
     * @param  string  $endpoint
     * @param  array  $parameters
     * @param  array  $requestHeaders
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function call(string $method, string $endpoint, array $parameters = [], array $requestHeaders = [])
    {
        if(!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new InvalidRequestMethodException('Wrong request method. Only supports GET, POST, PUT, DELETE');
        }

        $headers = $this->addRequestHeaders($requestHeaders);

        $path = $this->buildPath($endpoint);

        if($method === 'GET' && !empty($parameters)) {
            $path .= '?' . http_build_query($parameters);
            return $this->request->sendRequest($method, $path, false, $headers);
        }

        return $this->request->sendRequest($method, $path, $parameters, $headers);
    }

    /**
     * Add request headers
     *
     * @param  array  $headers
     *
     * @return array
     */
    public function addRequestHeaders(array $headers): array
    {
        $headers['Accept'] ='application/json';
        $headers['Content-Type'] ='application/json';
        $headers['api-key'] ='fake-api-key';

        return $headers;
    }

    /**
     * Build full path from endpoint
     *
     * @param  string  $endpoint
     *
     * @return string
     */
    public function buildPath(string $endpoint): string
    {
        return rtrim($this->client->getBaseUrl(), '/') . '/' . ltrim($endpoint, '/');
    }
}