<?php

namespace ThallesDKoester\Entregas;

use Exception;

/**
 * Thalles D. Koester | Class Entregas
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
class Entregas
{
    const FRETE_FORMATO_CAIXA = 1;
    const FRETE_FORMATO_ROLO = 2;
    const FRETE_FORMATO_ENVELOPE = 3;

    /**
     * @param string $cep
     * @return Cep
     */
    public static function cep(string $cep): Cep
    {
        return new Cep($cep);
    }

    /**
     * @param array      $zipcode
     * @param array      $methods
     * @param array      $item
     * @param array|null $options
     * @return Frete|null
     */
    public static function frete(array $zipcode, array $methods, array $item, ?array $options = null): ?Frete
    {
        try {
            return new Frete($zipcode, $methods, $item, $options);
        } catch (Exception $e) {
            trigger_error($e, E_USER_WARNING);
            return null;
        }
    }


    /**
     * @param string     $code
     * @param array|null $options
     * @return Rastreio
     */
    public static function rastreio(string $code, ?array $options = []): Rastreio
    {
        return new Rastreio($code, $options);
    }
}