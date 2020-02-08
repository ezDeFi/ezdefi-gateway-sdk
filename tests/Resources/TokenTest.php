<?php

namespace Ezdefi\Tests\Api;

use Ezdefi\Tests\Resources\BaseResourceTestCase;
use Ezdefi\Resources\Token;

class TokenTest extends BaseResourceTestCase
{
    protected $token;

    protected function setUp()
    {
        parent::setUp();

        $this->token = new Token($this->client, $this->request);
    }

    public function testGetTokenList()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token/list')
                      ->willReturn($expected);

        $actual = $this->token->getTokenList();

        $this->assertEquals('foo', $actual);
    }

    public function testGetTokenListWithParameters()
    {
        $expected = 'foo';

        $parameters = [
            'skip' => 1,
            'limit' => 10
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token/list?skip=1&limit=10')
                      ->willReturn($expected);

        $actual = $this->token->getTokenList($parameters);

        $this->assertEquals('foo', $actual);
    }

    public function testGetTokenDetail()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token/show/btc')
                      ->willReturn($expected);

        $actual = $this->token->getTokenDetail('btc');

        $this->assertEquals('foo', $actual);
    }

    public function testGetTokenExchange()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token/exchange/usd:btc')
                      ->willReturn($expected);

        $actual = $this->token->getTokenExchange('usd', 'btc');

        $this->assertEquals('foo', $actual);
    }

    public function testGetTokenExchanges()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/token/exchanges?amount=1.00&from=usd&to=btc%2Ceth')
                      ->willReturn($expected);

        $actual = $this->token->getTokenExchanges('1.00', 'usd', ['btc', 'eth']);

        $this->assertEquals('foo', $actual);
    }
}