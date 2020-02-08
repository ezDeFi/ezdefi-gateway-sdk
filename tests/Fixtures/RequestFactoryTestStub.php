<?php


namespace Ezdefi\Tests\Fixtures;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class RequestFactoryTestStub implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {

    }
}