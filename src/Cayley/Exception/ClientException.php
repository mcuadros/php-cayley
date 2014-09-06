<?php

namespace Cayley\Exception;
use Exception;
use RuntimeException;

class ClientException extends RuntimeException
{
    public function __construct(Exception $exception)
    {
        return parent::__construct(
            $exception->getMessage(),
            $exception->getCode()
        );
    }
}
