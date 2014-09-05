<?php

namespace Cayley\Gremlin;

class Path extends Statement
{
    public function __construct(Graph $graph)
    {
        $this->push((string) $graph);
    }

    public function out($predicatePath = null, $tags = null)
    {
        return $this->bounds('Out', $predicatePath, $tags);
    }

    public function in($predicatePath = null, $tags = null)
    {
        return $this->bounds('In', $predicatePath, $tags);
    }

    public function both($predicatePath = null, $tags = null)
    {
        return $this->bounds('Both', $predicatePath, $tags);
    }

    protected function bounds($method, $predicatePath = null, $tags = null)
    {
        if (!$predicatePath && !$tags) {
            $this->push(sprintf('%s()', $method));
        } else if (!$tags) {
            $this->push(sprintf(
                '%s(%s)',
                $method,
                $this->formatInputBounds($predicatePath)
            ));
        } else {
            $this->push(sprintf(
                '%s(%s, %s)',
                $method,
                $this->formatInputBounds($predicatePath),
                $this->formatInputBounds($tags)
            ));
        }

        return $this;
    }

    private function formatInputBounds($value)
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        if (is_string($value)) {
            return '"' . $value . '"';
        }

        if (!$value) {
            return 'null';
        }

        return $value;
    }

    public function is($nodes)
    {
        $this->pushMethodWithListOfStrings('Is', $nodes);

        return $this;
    }

    public function has($predicate, $object)
    {
        $this->push(sprintf('Has("%s", "%s")', $predicate, $object));

        return $this;
    }

    public function tag($tags)
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

    public function intersect(Vertex $query)
    {
        $this->push(sprintf('Intersect(%s)', $query));

        return $this;
    }

    public function union(Vertex $query)
    {
        $this->push(sprintf('Union(%s)', $query));

        return $this;
    }

    public function follow(Morphism $morphism)
    {
        $this->push(sprintf('Follow(%s)', $morphism));

        return $this;
    }

    public function followR(Morphism $morphism)
    {
        $this->push(sprintf('FollowR(%s)', $morphism));

        return $this;
    }
}
