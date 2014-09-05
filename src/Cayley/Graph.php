<?php

namespace Cayley;

class Graph extends Statement
{
    public function __construct()
    {
        $this->push('graph');
    }

    public function vertex(Array $nodes = null)
    {
        $this->pushMethodWithListOfStrings('Vertex', $nodes);

        return new Path($this);
    }

    public function v(Array $nodes = null)
    {
        return $this->Vertex();
    }

    public function morphism()
    {
        $this->push('Morphism()');

        return new Path($this);
    }

    public function m()
    {
        return $this->morphism();
    }

    public function emit($data)
    {
        $this->push(sprintf('Emit(%s)', json_encode($data)));

        return $this;
    }
}
