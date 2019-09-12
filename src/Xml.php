<?php

namespace ThallesDKoester\Entregas;

use SimpleXMLIterator;

/**
 * Thalles D. Koester | Trait Xml
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
trait Xml
{
    /**
     * @param string $xml
     * @return array
     */
    public function xml2array(string $xml): array
    {
        $sxi = new SimpleXMLIterator($xml);
        return self::sxiToArray($sxi);
    }

    /**
     * @param SimpleXMLIterator $sxi
     * @return array
     */
    private static function sxiToArray(SimpleXMLIterator $sxi): array
    {
        $a = [];
        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if (!array_key_exists($sxi->key(), $a)) {
                $a[$sxi->key()] = [];
            }

            if ($sxi->hasChildren()) {
                $a[$sxi->key()][] = self::sxiToArray($sxi->current());
            } else {
                $a[$sxi->key()][] = strval($sxi->current());
            }
        }
        return $a;
    }
}