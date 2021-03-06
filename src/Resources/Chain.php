<?php

namespace Ezdefi\Resources;

use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class Chain extends Resource
{
    /**
     * Get chain list
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getChainList()
    {
        return $this->get('chain/list');
    }
}