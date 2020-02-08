<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Resources\Payment;

class PaymentTest extends BaseResourceTestCase
{
    protected $payment;

    protected function setUp()
    {
        parent::setUp();

        $this->payment = new Payment($this->client, $this->request);
    }

    public function testGetPaymentsList()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/list')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentList();

        $this->assertEquals('foo', $actual);
    }

    public function testGetPaymentListWithParameters()
    {
        $expected = 'foo';

        $parameters = [
            'skip' => 1,
            'limit' => 10
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/list?skip=1&limit=10')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentList($parameters);

        $this->assertEquals('foo', $actual);
    }

    public function testGetPaymentDetail()
    {
        $expected = 'foo';

        $parameters = [
            'paymentid' => 'fakeid'
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/get?paymentid=fakeid')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentDetail($parameters);

        $this->assertEquals('foo', $actual);
    }

    public function testGetPaymentTxList()
    {
        $expected = 'foo';

        $parameters = [
            'paymentid' => 'fakeid'
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/list_tx?paymentid=fakeid')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentTxList($parameters);

        $this->assertEquals('foo', $actual);
    }

    public function testCreatePayment()
    {
        $expected = 'foo';

        $parameters = [
            'uoid' => 1,
            'to' => 'wallet address',
            'value' => 1,
            'currency' => 'usd:btc'
        ];

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('POST', 'http://foo.bar/payment/create', $parameters)
                      ->willReturn($expected);

        $actual = $this->payment->createPayment($parameters);

        $this->assertEquals('foo', $actual);
    }
}