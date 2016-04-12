<?php

namespace Cayley\Exception;

use RuntimeException;
use GuzzleHttp\Exception\ClientException;

class BadRequest extends RuntimeException
{
    public function __construct(ClientException $exception)
    {
        $data = json_decode($exception->getResponse()->getBody()->getContents(), true);

        return parent::__construct($data['error']);
    }
}
