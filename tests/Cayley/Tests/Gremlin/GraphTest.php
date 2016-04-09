<?php

namespace Cayley\Tests;

use Cayley\Gremlin\Graph;

class GraphTest extends TestCase
{
    public function testGraph()
    {
        $graph = new Graph();
        $this->assertEquals('graph', (string) $graph);
    }

    public function testEmit()
    {
        $graph = new Graph();
        $this->assertEquals($graph, $graph->emit('foo'));
        $this->assertEquals('graph.Emit("foo")', (string) $graph);
    }

    public function testMorphism()
    {
        $graph = new Graph();
        $this->assertInstanceOf('Cayley\Gremlin\Morphism', $graph->morphism());
        $this->assertEquals('graph.Morphism()', (string) $graph);
    }

    public function testVertex()
    {
        $graph = new Graph();
        $this->assertInstanceOf('Cayley\Gremlin\Vertex', $graph->vertex());
        $this->assertEquals('graph.Vertex()', (string) $graph);
    }

    public function testVertexWithNode()
    {
        $graph = new Graph();
        $this->assertInstanceOf('Cayley\Gremlin\Vertex', $graph->vertex(['foo']));
        $this->assertEquals('graph.Vertex("foo")', (string) $graph);
    }

    public function testVertexWithNodes()
    {
        $graph = new Graph();
        $this->assertInstanceOf('Cayley\Gremlin\Vertex', $graph->vertex(['foo', 'bar']));
        $this->assertEquals('graph.Vertex("foo", "bar")', (string) $graph);
    }
}
