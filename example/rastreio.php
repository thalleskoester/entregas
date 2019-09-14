<?php
require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

/*$rastreio = Entregas::rastreio('PU918142879BR');
var_dump($rastreio);*/

$rastreio = Entregas::rastreio('PU918142879BR');
$caminho = $rastreio->getPath();
var_dump($caminho, $rastreio);
