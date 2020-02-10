<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Exceptions\MissingArgumentException;
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

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/get?paymentid=fakeid')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentDetail('fakeid');

        $this->assertEquals('foo', $actual);
    }

    public function testGetPaymentDetailWithEmptyPaymentId()
    {
        try {
            $this->payment->getPaymentDetail('');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('PaymentId is required', $e->getMessage());
        }
    }

    public function testGetPaymentTxList()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/payment/list_tx?paymentid=fakeid')
                      ->willReturn($expected);

        $actual = $this->payment->getPaymentTxList('fakeid');

        $this->assertEquals('foo', $actual);
    }

    public function testGetPaymentTxListWithEmptyPaymentId()
    {
        try {
            $this->payment->getPaymentTxList('');
            $this->fail('Expected exception not thrown');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('PaymentId is required', $e->getMessage());
        }
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

    public function testCreatePaymentMissingRequiredFields()
    {
        $parameters = [
            'value' => 1,
            'currency' => 'usd:btc'
        ];

        try {
            $this->payment->createPayment($parameters);
            $this->fail('Expected exception not thrown');
        } catch (MissingArgumentException $e) {
            $this->assertEquals('Required parameters (uoid, to) are missing', $e->getMessage());
        }
    }
}