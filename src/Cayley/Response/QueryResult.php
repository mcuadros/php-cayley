<?php

namespace Cayley\Response;

use ArrayIterator;

class QueryResult extends ArrayIterator
{
    public function __construct($result)
    {
        return parent::__construct((Array) $result['result']);
    }
}
