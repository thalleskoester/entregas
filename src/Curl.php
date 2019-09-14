<?php

namespace ThallesDKoester\Entregas;

use Exception;

/**
 * Thalles D. Koester | Trait Curl
 *
 * @author  Thalles D. koester <thallesdella@gmail.com>
 * @package ThallesDKoester\Entregas
 */
trait Curl
{

    /**
     * @param string     $path
     * @param string     $method
     * @param array|null $params
     * @param int        $port
     * @return string
     * @throws Exception
     */
    private function request(string $path, string $method, ?array $params = null, ?int $port = null): string
    {
        $conn = curl_init();

        if ($conn === false) {
            throw new Exception('Erro na inicialízação do cURL.');
        }

        curl_setopt($conn, CURLOPT_URL, $path);
        curl_setopt($conn, CURLOPT_TIMEOUT, 30);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($conn, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($conn, CURLOPT_FORBID_REUSE, true);
        curl_setopt($conn, CURLOPT_HTTPHEADER, [
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded"
        ]);

        if (!empty($params) && count($params) > 0) {
            curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($params));
        } else {
            curl_setopt($conn, CURLOPT_POSTFIELDS, null);
        }

        if ($port !== null) {
            curl_setopt($conn, CURLOPT_PORT, $port);
        }

        $data = curl_exec($conn);
        $err = curl_error($conn);
        curl_close($conn);

        if ($err) {
            throw new Exception($err);
        } else {
            return $this->validateData($data);
        }
    }

    /**
     * @param $response
     * @return string
     * @throws Exception
     */
    private function validateData($response): string
    {
        if (empty($response)) {
            throw new Exception("curl could not reach the server.");
        }

        if (!$response) {
            throw new Exception($response);
        }
        return $response;
    }
}