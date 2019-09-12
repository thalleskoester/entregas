<?php
require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

$cep = Entregas::cep('22470-230')->getAddr();
print_r($cep);

$cep = Entregas::cep('22470-230');
$addr = $cep->getAddr();

if (empty($addr)) {
    echo $cep->getError();
}