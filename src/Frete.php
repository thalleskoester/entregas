<?php

namespace ThallesDKoester\Entregas;

use Exception;

/**
 * Thalles D. Koester | Class Frete
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
class Frete
{
    use Curl;
    use Xml;

    const URL_CORREIOS = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';

    /** @var array */
    private $zipcode;

    /** @var string */
    private $types;

    /** @var array */
    private $item;

    /** @var string */
    private $error;

    /** @var array */
    private $options = [];

    /** @var array */
    private $methods = [
        'sedex' => '04014',
        'sedex_a_cobrar' => '04065',
        'sedex_10' => '40215',
        'sedex_hoje' => '40290',
        'pac' => '04510',
        'pac_a_cobrar' => '04707',
        'pac_contrato' => '04669',
        'sedex_contrato' => '04162',
        'esedex' => '81019',
    ];

    /**
     * Frete constructor.
     * @param array      $zipcode
     * @param array      $types
     * @param array      $item
     * @param array|null $options
     * @throws Exception
     */
    public function __construct(array $zipcode, array $types, array $item, ?array $options = null)
    {
        $this->setZipcode($zipcode);
        $this->setTypes($types);
        $this->setItem($item);

        if ($options) {
            $this->setOptions($options);
        }
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string|null $type
     * @return array|string
     */
    public function getTypesAvailable(?string $type = null)
    {
        if ($type) {
            return $this->methods[$type];
        }
        return $this->methods;
    }

    /**
     * @param string $value
     * @return string
     */
    public function getTypesIndex(string $value): ?string
    {
        $data = array_search($value, $this->methods);
        return ($data ? $data : null);
    }

    /**
     * @return array|null
     */
    public function getFrete(): ?array
    {
        $url = self::URL_CORREIOS . '?' . $this->generatePayload();
        try {
            $data = $this->request($url, 'GET');
        } catch (Exception $e) {
            $this->error = $e;
            return null;
        }

        $fretes = $this->xml2array($data)['Servicos'][0]['cServico'];

        $return = [];
        foreach ($fretes as $frete) {
            $return[] = [
                'codigo' => (int)$frete['Codigo'][0],
                'valor' => $frete['Valor'][0],
                'prazo' => $frete['PrazoEntrega'][0],
                'mao_propria' => $frete['ValorMaoPropria'][0],
                'aviso_recebimento' => $frete['ValorAvisoRecebimento'][0],
                'valor_declarado' => $frete['ValorValorDeclarado'][0],
                'entrega_domiciliar' => ($frete['EntregaDomiciliar'][0] === 'S' ? true : false),
                'entrega_sabado' => ($frete['EntregaSabado'][0] === 'S' ? true : false),
                'error' => ['codigo' => (int)$frete['Erro'][0], 'mensagem' => $frete['MsgErro'][0]],
            ];
        }
        return $return;
    }

    /**
     * @param array $zipcode
     */
    private function setZipcode(array $zipcode): void
    {
        $this->zipcode = array_map(function ($zip) {
            return preg_replace("/[^0-9]/", "", $zip);
        }, $zipcode);
    }

    /**
     * @param array $types
     * @throws Exception
     */
    private function setTypes(array $types): void
    {
        $newTypes = [];
        foreach ($types as $key => $value) {
            if (empty($this->methods[$value])) {
                throw new Exception("Tipo de frete {$value} não está disponível para uso.");
            }
            $newTypes[] = $this->methods[$value];
        }
        $this->types = implode(",", $newTypes);
    }

    /**
     * @param array $item
     */
    private function setItem(array $item): void
    {
        $this->item = $item;
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
     * @return string
     */
    private function generatePayload(): string
    {
        $this->options['valor_declarado'] = (!empty($this->options['valor_declarado'])
            ? number_format($this->options['valor_declarado'], '2', ',', '') : 0);
        $this->item['peso'] = floatval($this->item['peso'] / 1000);
        $this->item['altura'] = ($this->item['altura'] > 2 ? $this->item['altura'] : 2);
        $this->item['comprimento'] = ($this->item['comprimento'] > 11 ? $this->item['comprimento'] : 11);
        $this->item['largura'] = ($this->item['largura'] > 16 ? $this->item['largura'] : 16);

        $payload = [
            'nCdServico' => $this->types,
            'nCdEmpresa' => ($this->options['empresa'] ?? ''),
            'sDsSenha' => ($this->options['senha'] ?? ''),
            'sCepOrigem' => $this->zipcode['origem'],
            'sCepDestino' => $this->zipcode['destino'],
            'nVlPeso' => $this->item['peso'],
            'nCdFormato' => $this->item['formato'],
            'nVlComprimento' => $this->item['comprimento'],
            'nVlAltura' => $this->item['altura'],
            'nVlLargura' => $this->item['largura'],
            'nVlDiametro' => ($this->item['diametro'] ?? 0),
            'sCdMaoPropria' => (isset($this->options['mao_propria'])
            && $this->options['mao_propria'] ? 'S' : 'N'),
            'nVlValorDeclarado' => ($this->options['valor_declarado'] ?? 0),
            'sCdAvisoRecebimento' => (isset($this->options['aviso_recebimento'])
            && $this->options['aviso_recebimento'] ? 'S' : 'N'),
            'sDtCalculo' => date('d/m/Y'),
            'StrRetorno' => 'xml'
        ];

        return http_build_query($payload);
    }
}