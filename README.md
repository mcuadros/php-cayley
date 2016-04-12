php-cayley [![Build Status](https://travis-ci.org/mcuadros/php-cayley.png?branch=master)](https://travis-ci.org/mcuadros/php-cayley)
==============================

PHP Wrapper for the [Google's Cayley](https://github.com/google/cayley) graph database REST interface.

> Cayley is an open-source graph inspired by the graph database behind [Freebase](http://freebase.com/) and Google's [Knowledge Graph](http://www.google.com/insidesearch/features/search/knowledge.html). Its goal is to be a part of the developer's toolbox where [Linked Data](http://linkeddata.org/) and graph-shaped data (semantic webs, social networks, etc) in general are concerned.

The Cayley's default query language is called [Gremlin](http://gremlindocs.com/) based on JavaScript. php-cayley is a replica of this [Gremlin Javascript API](https://github.com/google/cayley/blob/master/docs/GremlinAPI.md) in PHP, all the methods and patterns from Gremlin are applicable to this library.

Requirements
------------

* php >=5.5.0
* guzzlehttp/guzzle ~6.0


Installation
------------

The recommended way to install php-cayley is [through composer](http://getcomposer.org).
You can see [the package information on Packagist.](https://packagist.org/packages/mcuadros/php-cayley)

```JSON
{
    "require": {
        "mcuadros/php-cayley": "dev-master"
    }
}
```


Usage
-----

### Basic example

```php
$cayley = new Cayley\Client();
$query = $cayley->graph()->vertex('Humphrey Bogart')->all();
$result = $cayley->query($query);
print_r($result);
```

### Morphism example

```php
$cayley = new Cayley\Client();

$filmToActor = $cayley->graph()
    ->morphism()
    ->out('/film/film/starring')
    ->out('/film/performance/actor');

$query = $cayley->graph()
    ->vertex()
    ->has('name', 'Casablanca')
    ->follow($filmToActor)
    ->out('name')
    ->all();

$starring = $cayley->query($query);
foreach($starring as $actor) {
    var_dump($actor['id']);
}

```

These examples are based on the data contained in the example database `30kmoviedata.nq.gz`

For more information please read [Gremlin Javascript API](https://github.com/google/cayley/blob/master/docs/GremlinAPI.md) documentation.

Tests
-----

Tests are in the `tests` folder.
To run them, you need PHPUnit.
Example:

    $ phpunit --configuration phpunit.xml.dist


License
-------

MIT, see [LICENSE](LICENSE)
