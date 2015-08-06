<?php

namespace Cayley\Gremlin;

class Statement
{
    private $statements = [];

    protected function push($statement)
    {
        $this->statements[] = $statement;
    }

    protected function pushMethodWithListOfStrings($method, $strings = null)
    {
        $formatted = '';
        if ($strings) {
            $formatted = sprintf('"%s"', implode('", "', (array) $strings));
        }

        $this->push(sprintf('%s(%s)', $method, $formatted));
    }

    public function __toString()
    {
        return implode('.', $this->statements);
    }
}
