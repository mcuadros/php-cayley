<?php

namespace Cayley\Tests;

use Cayley\Gremlin\Graph;

class VertexTest extends TestCase
{
    public function testAll()
    {
        $graph = new Graph();
        $vertex = $graph->v();
        $this->assertEquals($vertex, $vertex->all());
        $this->assertEquals('graph.Vertex().All()', (string) $vertex);
    }

    public function testGetLimit()
    {
        $graph = new Graph();
        $vertex = $graph->v();
        $this->assertEquals($vertex, $vertex->getLimit(42));
        $this->assertEquals('graph.Vertex().GetLimit(42)', (string) $vertex);
    }
}
