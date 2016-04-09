<?php

require __DIR__.'/../vendor/autoload.php';

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
foreach ($starring as $actor) {
    var_dump($actor['id']);
}
