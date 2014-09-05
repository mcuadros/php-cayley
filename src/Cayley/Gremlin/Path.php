<?php

namespace Cayley\Gremlin;

class Path extends Statement
{
    public function __construct(Graph $graph)
    {
        $this->push((string) $graph);
    }

    public function out(Path $predicatePath = null, $tags = null)
    {
        return $this->bounds('Out', $predicatePath, (array) $tags);
    }

    public function in(Path $predicatePath = null, $tags = null)
    {
        return $this->bounds('In', $predicatePath, (array) $tags);
    }

    public function both(Path $predicatePath = null, $tags = null)
    {
        return $this->bounds('Both', $predicatePath, (array) $tags);
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
