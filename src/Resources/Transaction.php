<?php

namespace Ezdefi\Resources;

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
     * @throws InvalidRequestMethodException
     */
    public function getTransactionDetail(string $transactionId)
    {
        $parameters = [
            'id' => $transactionId
        ];

        return $this->get('transaction/get', $parameters);
    }
}