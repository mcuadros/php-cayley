<?php

namespace Cayley\Gremlin;

class Path extends Statement
{
    public function __construct(Graph $graph)
    {
        $this->push((string) $graph);
    }

    public function out(Path $predicatePath = null, Array $tags = null)
    {
        return $this->bounds('Out', $predicatePath, $tags);
    }

    public function in(Path $predicatePath = null, Array $tags = null)
    {
        return $this->bounds('In', $predicatePath, $tags);
    }

    public function both(Path $predicatePath = null, Array $tags = null)
    {
        return $this->bounds('Both', $predicatePath, $tags);
    }

    protected function bounds($method, Path $predicatePath = null, Array $tags = null)
    {
        if (!$predicatePath && !$tags) {
            $this->push(sprintf('%s()', $method));
        } else if ($predicatePath && !$tags) {
            $this->push(sprintf('%s(%s)', $method, $predicatePath));
        } else if (!$predicatePath && $tags) {
            $this->push(sprintf('%s(%s)', $method, json_encode($tags)));
        } else {
            $this->push(sprintf(
                '%s(%s, %s)',
                $method,
                $predicatePath,
                json_encode($tags)
            ));
        }

        return $this;
    }

    public function is(Array $nodes)
    {
        $this->pushMethodWithListOfStrings('Is', $nodes);

        return $this;
    }

    public function has($predicate, $object)
    {
        $this->push(sprintf('Has("%s", "%s")', $predicate, $object));

        return $this;
    }

    public function tag(Array $tags)
    {
        $this->pushMethodWithListOfStrings('Tag', $tags);

        return $this;
    }

    public function back($tag)
    {
        $this->push(sprintf('Back("%s")', $tag));

        return $this;
    }

    public function save($predicate, $object)
    {
        $this->push(sprintf('Save("%s", "%s")', $predicate, $object));

        return $this;
    }

    public function intersect(Path $query)
    {
        $this->push(sprintf('Intersect(%s)', $query));

        return $this;
    }

    public function union(Path $query)
    {
        $this->push(sprintf('Union(%s)', $query));

        return $this;
    }
}
