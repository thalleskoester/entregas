<?php

namespace ThallesDKoester\Entregas;

use Exception;

/**
 * Thalles D. Koester | Class Cep
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
class Cep
{
    use Curl;

    const URL_VIACEP = 'http://viacep.com.br/ws';

    /** @var string */
    private $cep;

    /** @var string */
    private $error;

    /**
     * Cep constructor.
     * @param string $cep
     */
    public function __construct(string $cep)
    {
        $this->cep = preg_replace("/[^0-9]/", "", $cep);
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function getAddr(): ?array
    {
        $url = self::URL_VIACEP . "/{$this->cep}/json/";

        try {
            $data = $this->request($url, 'GET');
        } catch (Exception $e) {
            $this->error = $e;
            $data = null;
        } finally {
            return array_filter(json_decode($data, true));
        }
    }
}