<?php

namespace Ezdefi\Resources;

use Ezdefi\Exceptions\InvalidArgumentException;
use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class Transaction extends Resource
{
    /**
     * Get transaction detail
     *
     * @param  string  $transactionId
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidRequestMethodException
     */
    public function getTransactionDetail(string $transactionId)
    {
        if(empty($transactionId)) {
            throw new InvalidArgumentException('TransactionId is required');
        }

        $parameters = [
            'id' => $transactionId
        ];

        return $this->get('transaction/get', $parameters);
    }
}