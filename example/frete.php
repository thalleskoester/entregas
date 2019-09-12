<?php
require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

$frete = Entregas::frete(
    ['origem' => '22461-200', 'destino' => '25620-160'],
    ['pac', 'sedex'],
    [
        'peso' => '1000',
        'formato' => Entregas::FRETE_FORMATO_CAIXA,
        'comprimento' => '30',
        'altura' => '15',
        'largura' => '20'
    ]);
var_dump($frete);

$frete = Entregas::frete(
    ['origem' => '22461-200', 'destino' => '25620-160'],
    ['pac', 'sedex'],
    [
        'peso' => '1000',
        'formato' => Entregas::FRETE_FORMATO_CAIXA,
        'comprimento' => '30',
        'altura' => '15',
        'largura' => '20'
    ])->getFrete();
var_dump($frete);