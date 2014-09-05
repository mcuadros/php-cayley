<?php

namespace Cayley;

class Statement
{
    private $statements = [];

    protected function push($statement)
    {
       $this->statements[] = $statement;
    }

    public function __toString()
    {
        return implode('.', $this->statements);
    }
}
