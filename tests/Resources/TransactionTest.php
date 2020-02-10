<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Resources\Transaction;

class TransactionTest extends BaseResourceTestCase
{
    protected $transaction;

    protected function setUp()
    {
        parent::setUp();

        $this->transaction = new Transaction($this->client, $this->request);
    }

    public function testGetTransactionDetail()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/transaction/get?id=transactionid')
                      ->willReturn($expected);

        $actual = $this->transaction->getTransactionDetail('transactionid');

        $this->assertEquals($expected, $actual);
    }

    public function testGetTransactionDetailWithEmptyId()
    {
        try {
            $this->transaction->getTransactionDetail('');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('TransactionId is required', $e->getMessage());
        }
    }
}