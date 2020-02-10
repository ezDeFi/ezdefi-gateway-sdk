<?php

namespace Ezdefi\Resources;

use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Exceptions\MissingArgumentException;
use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class Payment extends Resource
{
    /**
     * Get payment list
     *
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getPaymentList(array $parameters = [])
    {
        return $this->get('payment/list', $parameters);
    }

    /**
     * Get payment TX list
     *
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidRequestMethodException
     */
    public function getPaymentTxList(string $paymentId)
    {
        if(empty($paymentId)) {
            throw new InvalidArgumentException('PaymentId is required');
        }

        $parameters = [
            'paymentid' => $paymentId
        ];

        return $this->get('payment/list_tx', $parameters);
    }

    /**
     * Get payment detail
     *
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidRequestMethodException
     */
    public function getPaymentDetail(string $paymentId)
    {
        if(empty($paymentId)) {
            throw new InvalidArgumentException('PaymentId is required');
        }

        $parameters = [
            'paymentid' => $paymentId
        ];

        return $this->get('payment/get', $parameters);
    }

    /**
     * Create payment
     *
     * @param  array  $data
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     * @throws MissingArgumentException
     */
    public function createPayment(array $data)
    {
        $required = ['uoid', 'to', 'value', 'currency'];

        $missing = [];

        foreach($required as $key) {
            if (!isset($data[$key]) || empty($data[$key])) {
                $missing[] = $key;
            }
        }

        if (!empty($missing)) {
            throw new MissingArgumentException($missing);
        }

        return $this->post('payment/create', $data);
    }
}