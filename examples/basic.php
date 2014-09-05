<?php
require __DIR__.'/../vendor/autoload.php';

$cayley = new Cayley\Client();
$query = $cayley->graph()->vertex('Humphrey Bogart')->all();
$result = $cayley->query($query);
print_r($result);
