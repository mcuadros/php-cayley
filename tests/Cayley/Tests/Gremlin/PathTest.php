<?php

namespace Cayley\Tests;
use Cayley\Gremlin\Path;
use Cayley\Gremlin\Graph;

class PathTest extends TestCase
{
    public function buildPath()
    {
        $graph = new Graph();

        return new Path($graph);
    }

    public function testPath()
    {
        $path = $this->buildPath();
        $this->assertEquals('graph', (string) $path);
    }

    public function testOut()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->out());
        $this->assertEquals('graph.Out()', (string) $path);
    }

    public function testOutWithPredicatePath()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->out((new Graph())->v()));
        $this->assertEquals('graph.Out(graph.Vertex())', (string) $path);
    }

    public function testOutWithLabel()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->out(['foo', 'bar'], 'foo'));
        $this->assertEquals('graph.Out(["foo","bar"], "foo")', (string) $path);
    }

    public function testOutWithLabels()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->out(null, ['foo', 'bar']));
        $this->assertEquals('graph.Out(null, ["foo","bar"])', (string) $path);
    }

    public function testOutWithPredicatePathAndLabels()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->out((new Graph())->v(), ['foo', 'bar']));
        $this->assertEquals('graph.Out(graph.Vertex(), ["foo","bar"])', (string) $path);
    }

    public function testIn()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->in());
        $this->assertEquals('graph.In()', (string) $path);
    }

    public function testBoth()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->both());
        $this->assertEquals('graph.Both()', (string) $path);
    }

    public function testIs()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->is(['foo', 'bar']));
        $this->assertEquals('graph.Is("foo", "bar")', (string) $path);
    }

    public function testHas()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->has('foo', 'bar'));
        $this->assertEquals('graph.Has("foo", "bar")', (string) $path);
    }

    public function testTag()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->tag(['foo', 'bar']));
        $this->assertEquals('graph.Tag("foo", "bar")', (string) $path);
    }

    public function testBack()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->back('foo'));
        $this->assertEquals('graph.Back("foo")', (string) $path);
    }

    public function testSave()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->save('foo', 'bar'));
        $this->assertEquals('graph.Save("foo", "bar")', (string) $path);
    }

    public function testIntersect()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->intersect((new Graph())->v()));
        $this->assertEquals('graph.Intersect(graph.Vertex())', (string) $path);
    }

    public function testUnion()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->union((new Graph())->v()));
        $this->assertEquals('graph.Union(graph.Vertex())', (string) $path);
    }

    public function testFollow()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->follow((new Graph())->m()));
        $this->assertEquals('graph.Follow(graph.Morphism())', (string) $path);
    }

    public function testFollowR()
    {
        $path = $this->buildPath();
        $this->assertEquals($path, $path->followR((new Graph())->m()));
        $this->assertEquals('graph.FollowR(graph.Morphism())', (string) $path);
    }
}
