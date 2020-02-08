<?php

namespace Ezdefi\Resources;

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
     * @throws InvalidRequestMethodException
     */
    public function getPaymentTxList(array $parameters = [])
    {
        return $this->get('payment/list_tx', $parameters);
    }

    /**
     * Get payment detail
     *
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getPaymentDetail(array $parameters = [])
    {
        return $this->get('payment/get', $parameters);
    }

    /**
     * Create payment
     *
     * @param  array  $data
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function createPayment(array $data)
    {
        return $this->post('payment/create', $data);
    }
}