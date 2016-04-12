<?php

namespace Cayley\Tests;

use Cayley\Gremlin\Graph;

class GraphIntegrationTest extends TestCase
{
    public function testSimpleVertex()
    {
        $graph = new Graph();
        $query = $graph->vertex('Humphrey Bogart')->all();

        $this->assertEquals(
            'graph.Vertex("Humphrey Bogart").All()',
            (string) $query
        );
    }

    public function testIntersect()
    {
        $graphA = new Graph();
        $cFollows = $graphA->v('C')->out('follows');

        $graphB = new Graph();
        $dFollows = $graphB->v('D')->out('follows');
        $cFollows->intersect($dFollows);

        $this->assertEquals(
            'graph.Vertex("C").Out("follows").Intersect(graph.Vertex("D").Out("follows")).All()',
            (string) $cFollows->all()
        );
    }
}
