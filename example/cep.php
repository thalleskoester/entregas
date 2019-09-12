<?php
require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

$cep = Entregas::cep('22461-200');
var_dump($cep);
$cep = Entregas::cep('22461-200')->getAddr();
var_dump($cep);