<?php

namespace Cayley\Tests;
use Cayley\Client;
use Cayley\Gremlin\Graph;

class ClientTest extends TestCase
{
    public function testQuery()
    {
        $cayley = new Client();

        $graph = new Graph();
        $graph->emit('Hello World');

        $result = $cayley->query($graph);

        $this->assertInstanceOf('Cayley\Response\QueryResult', $result);
        $this->assertEquals('Hello World', reset($result));
    }

    public function testQueryWithGremlin()
    {
        $cayley = new Client();
        $result = $cayley->queryWithGremlin('g.Emit("Hello World")');

        $this->assertInstanceOf('Cayley\Response\QueryResult', $result);
        $this->assertEquals('Hello World', reset($result));
    }

    /**
     * @expectedException Cayley\Exception\BadRequest
     */
    public function testQueryWithGremlinParserError()
    {
        $cayley = new Client();
        $result = $cayley->queryWithGremlin('foo(');

        $this->assertInstanceOf('Cayley\Response\QueryResult', $result);
        $this->assertEquals('Hello World', reset($result));
    }

    /**
     * @expectedException Cayley\Exception\ClientException
     */
    public function testQueryWithGremlinWithIncorrectPort()
    {
        $cayley = new Client('0.0.0.0', 1234);
        $result = $cayley->queryWithGremlin('foo(');

        $this->assertInstanceOf('Cayley\Response\QueryResult', $result);
        $this->assertEquals('Hello World', reset($result));
    }
}
