<?php

namespace Cayley;

class Statement
{
    private $statements = [];

    protected function push($statement)
    {
       $this->statements[] = $statement;
    }

    protected function pushMethodWithListOfStrings($method, Array $strings = null)
    {
        $formated = '';
        if ($strings) {
            $formated = sprintf('"%s"', implode('", "', $strings));
        }

        $this->push(sprintf('%s(%s)', $method, $formated));
    }

    public function __toString()
    {
        return implode('.', $this->statements);
    }
}
