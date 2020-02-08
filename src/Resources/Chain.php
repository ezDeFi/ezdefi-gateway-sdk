<?php

namespace Ezdefi\Resources;

use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class Chain extends Resource
{
    /**
     * Get chain list
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getChainList()
    {
        return $this->get('chain/list');
    }

    /**
     * Get chain detail
     *
     * @param  string  $keyword
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getChainDetail(string $keyword)
    {
        return $this->get('chain/show', ['keyword' => $keyword]);
    }
}