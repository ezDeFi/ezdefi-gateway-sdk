<?php

namespace Ezdefi\Tests\Api;

use Ezdefi\Tests\Resources\BaseResourceTestCase;
use Ezdefi\Resources\Chain;

class ChainTest extends BaseResourceTestCase
{
    protected $chain;

    protected function setUp()
    {
        parent::setUp();

        $this->chain = new Chain($this->client, $this->request);
    }

    public function testGetChainList()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/chain/list')
                      ->willReturn($expected);

        $actual = $this->chain->getChainList();

        $this->assertEquals($expected, $actual);
    }

    public function testGetChainDetail()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/chain/show?keyword=bitcoin')
                      ->willReturn($expected);

        $actual = $this->chain->getChainDetail('bitcoin');

        $this->assertEquals($expected, $actual);
    }
}