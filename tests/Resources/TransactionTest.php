<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Resources\Transaction;

class TransactionTest extends BaseResourceTestCase
{
    protected $transaction;

    protected function setUp()
    {
        parent::setUp();

        $this->transaction = new Transaction($this->client, $this->request);
    }

    public function testGetUserDetail()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/transaction/get?id=transactionid')
                      ->willReturn($expected);

        $actual = $this->transaction->getTransactionDetail('transactionid');

        $this->assertEquals($expected, $actual);
    }
}