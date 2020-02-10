<?php

namespace Ezdefi;

use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Exceptions\InvalidResourceException;

class Client
{
    /**
     * Base URL
     *
     * @var string
     */
    protected $baseUrl = 'http://merchant-api.ezdefi.com/api';

    /**
     * API Key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Request Instance
     */
    protected $request;

    /**
     * Client constructor.
     *
     * @param  string  $apiKey
     * @param  string  $baseUrl
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $apiKey)
    {
        if(empty($apiKey)) {
            throw new InvalidArgumentException('API key is required');
        }

        $this->apiKey = $apiKey;
    }

    /**
     * Get resource instance
     *
     * @param $resourceName
     *
     * @return mixed
     * @throws InvalidResourceException
     */
    public function __get($resourceName)
    {
        $class = 'Ezdefi\Resources\\' . ucfirst($resourceName);

        if(class_exists($class)) {
            $resource = new $class($this, new Request());
            return $resource;
        }

        throw new InvalidResourceException(ucfirst($resourceName) . ' resource not exist');
    }

    /**
     * Get API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set API Key
     *
     * @param  string  $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get Base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set Base URL
     *
     * @param  string  $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}