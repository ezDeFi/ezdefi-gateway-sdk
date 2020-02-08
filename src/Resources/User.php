<?php

namespace Ezdefi\Resources;

use Ezdefi\Resource;
use Ezdefi\Exceptions\InvalidRequestMethodException;

class User extends Resource
{
    /**
     * Get user detail
     *
     * @return mixed
     * @throws InvalidRequestMethodException
     */
    public function getUserDetail()
    {
        return $this->get('user/show');
    }
}