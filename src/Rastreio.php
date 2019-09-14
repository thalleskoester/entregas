<?php

namespace ThallesDKoester\Entregas;

use Exception;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Thalles D. Koester | Class Rastreio
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
class Rastreio
{
    use Curl;

    const ALTERNATIVE = 'https://www2.correios.com.br/sistemas/rastreamento/resultado_semcontent.cfm';

    /** @var string */
    private $code;

    /** @var string */
    private $error;

    /** @var array */
    private $options = [];

    /**
     * Rastreio constructor.
     * @param string     $code
     * @param array|null $options
     */
    public function __construct(string $code, ?array $options = [])
    {
        $this->setCode($code);

        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * @return array|null
     */
    public function getPath(): ?array
    {
        $url = self::ALTERNATIVE;
        try {
            $data = $this->request($url, 'POST', ['Objetos' => $this->code]);
        } catch (Exception $e) {
            $this->error = $e;
            return null;
        }

        return $this->parseHtml($data);
    }

    /**
     * @param string $code
     */
    private function setCode(string $code): void
    {
        if (empty($code)) {
            $this->error = 'Insira o código de rastreio para proceguir';
        }
        $this->code = $code;
    }

    /**
     * @param array $options
     */
    private function setOptions(array $options): void
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
    }

    /**
     * @param string $hmtl
     * @return array|null
     */
    private function parseHtml(string $hmtl): ?array
    {
        $dom = HtmlDomParser::str_get_html($hmtl);
        $table = $dom->find('.listEvent');

        if (!$table) {
            $this->error = 'Erro no parsing';
            return null;
        }

        $return = [];
        foreach ($table->children() as $key => $value) {
            $datetime = explode('<br />', $value->find('.sroDtEvent')->plaintext);
            $return[] = [
                'date' => $datetime[0],
                'time' => $datetime[1],
                'location' => strip_tags($datetime[2]),
                'action' => strip_tags($value->find('.sroLbEvent')->plaintext)
            ];
        }
        return $return;
    }
}