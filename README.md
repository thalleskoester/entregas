# Entregas Library

[![Maintainer](http://img.shields.io/badge/maintainer-@thalleskoester-blue.svg?style=flat-square)](https://www.instagram.com/thalleskoester/)
[![Source Code](http://img.shields.io/badge/source-thallesdella/entregas-blue.svg?style=flat-square)](https://github.com/thallesdella/entregas)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/thallesdella/entregas.svg?style=flat-square)](https://packagist.org/packages/thallesdella/entregas)
[![Latest Version](https://img.shields.io/github/release/thallesdella/entregas.svg?style=flat-square)](https://github.com/thallesdella/entregas/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/thallesdella/entregas.svg?style=flat-square)](https://scrutinizer-ci.com/g/thallesdella/entregas)
[![Quality Score](https://img.shields.io/scrutinizer/g/thallesdella/entregas.svg?style=flat-square)](https://scrutinizer-ci.com/g/thallesdella/entregas)
[![Total Downloads](https://img.shields.io/packagist/dt/thallesdella/entregas.svg?style=flat-square)](https://packagist.org/packages/cthallesdella/entregas)


Entregas Library vem na intenção de facilitar a consulta de serviços relacionados a entregas, como consulta de CEP, calculo de frete... 


### Destaques

- Instalação simples
- Facil utilização
- Pronto para o composer e compatível com PSR-2

## Instalação

Entregas esta disponível atraves do composer:

```bash
"thallesdella/entregas": "^1.0"
```

Ou execute

```bash
composer require thallesdella/entregas
```

## Documentação

Para mais detalhes sobre como usar, veja uma pasta de exemplo no diretório do componente. Nela terá um exemplo de uso para cada método. Ela funciona assim:

#### Endereço a partir do cep:

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use ThallesDKoester\Entregas\Entregas;

$cep = Entregas::cep('22470-230')->getAddr();
print_r($cep);

$cep = Entregas::cep('22470-230');
$addr = $cep->getAddr();

if (empty($addr)){
    echo $cep->getError();
}
```

#### Calcular Frete:

```php
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
```

#### Rastreio:
Em breve

### Outros

Você também conta com classes para os endpoints de carteiras e assinaturas, toda documentação de uso com exemplos práticos está disponível na pasta examples desta biblioteca. Por favor, consulte lá.

## Contribuindo

Por favor veja [CONTRIBUINDO](https://github.com/thallesdella/entregas/blob/master/CONTRIBUTING.md) para detalhes.

## Suporte

Se você descobrir algum problema relacionado à segurança, envie um e-mail para thallesdella@gmail.com em vez de usar o rastreador de problemas.

Obrigado

## Créditos

- [Thalles D. Koester](https://github.com/thallesdella) (Desenvolvedor)
- [Todos os Contribuidores](https://github.com/thallesdella/entregas/contributors) (Pessoas Incríveis)

## Licensa

Licensa MIT (MIT). Por favor veja [Arquivo de Licensa](https://github.com/thallesdella/entregas/blob/master/LICENSE) para mais informações.