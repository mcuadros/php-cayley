<?php

namespace Cayley\Exception;
use RuntimeException;
use GuzzleHttp\Exception\ClientException;

class BadRequest extends RuntimeException
{
    public function __construct(ClientException $exception)
    {
        $data = $exception->getResponse()->json();
        return parent::__construct($data['error']);
    }
}
