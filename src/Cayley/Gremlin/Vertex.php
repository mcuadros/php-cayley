<?php

namespace Cayley\Gremlin;

class Vertex extends Path
{
    public function all()
    {
        $this->push('All()');

        return $this;
    }

    public function getLimit($limit)
    {
        $this->push(sprintf('GetLimit(%d)', $limit));

        return $this;
    }
}
