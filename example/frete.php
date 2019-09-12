<?php
require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

$frete = Entregas::frete(
    ['origem' => '22470-230', 'destino' => '24348-190'],
    ['pac'],
    [
        'peso' => '1000',
        'formato' => Entregas::FRETE_FORMATO_CAIXA,
        'comprimento' => '30',
        'altura' => '15',
        'largura' => '20'
    ])->getFrete();
print_r($frete);

$frete = Entregas::frete(
    ['origem' => '22470-230', 'destino' => '24348-190'],
    ['pac', 'sedex'],
    [
        'peso' => '1000',
        'formato' => Entregas::FRETE_FORMATO_CAIXA,
        'comprimento' => '30',
        'altura' => '15',
        'largura' => '20'
    ])->getFrete();
print_r($frete);

$frete = Entregas::frete(
    ['origem' => '22470-230', 'destino' => '24348-190'],
    ['pac', 'sedex'],
    [
        'peso' => '1000',
        'formato' => Entregas::FRETE_FORMATO_CAIXA,
        'comprimento' => '30',
        'altura' => '15',
        'largura' => '20'
    ]);
$data = $cep->getAddr();

if (empty($data)) {
    echo $frete->getError();
}