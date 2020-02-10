<?php

namespace Ezdefi\Exceptions;

class MissingArgumentException extends \Exception
{
    public function __construct(array $missing, $code = 0, $previous = null)
    {
        parent::__construct(sprintf('Required parameters (%s) are missing', implode(', ', $missing)), $code, $previous);
    }
}