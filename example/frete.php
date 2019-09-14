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
var_dump($frete);

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

if (!$frete) {
    echo $frete->getError();
} else {
    $data = $frete->getFrete();
    if (!$data) {
        echo $frete->getError();
    }
    var_dump($data);
}
