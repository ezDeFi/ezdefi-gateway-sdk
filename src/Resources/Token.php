<?php

namespace Ezdefi\Resources;

use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class Token extends Resource
{
    /**
     * Get token list
     *
     * @param  array  $parameters
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getTokenList(array $parameters = [])
    {
        return $this->get('token/list', $parameters);
    }

    /**
     * Get token detail
     *
     * @param  string  $_id
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getTokenDetail(string $_id)
    {
        return $this->get('token/show/' . $_id);
    }

    /**
     * Get token exchange
     *
     * @param  string  $fiat
     * @param  string  $token
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getTokenExchange(string $fiat, string $token)
    {
        return $this->get('token/exchange/' . $fiat . ':' . $token);
    }

    /**
     * Get token exchanges
     *
     * @param  string  $amount
     * @param  string  $from
     * @param  array  $to
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getTokenExchanges(string $amount, string $from, array $to)
    {
        $parameters = [
            'amount' => $amount,
            'from' => $from,
            'to' => implode(',', $to)
        ];

        return $this->get('token/exchanges', $parameters);
    }
}