<?php

namespace Ezdefi\Tests\Fixtures;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactoryTestStub implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        // TODO: Implement createStream() method.
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        // TODO: Implement createStreamFromFile() method.
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        // TODO: Implement createStreamFromResource() method.
    }
}