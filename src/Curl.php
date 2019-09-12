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
     * @return array|null
     * @throws Exception
     */
    public function request(string $path, string $method, ?array $params = null, int $port = 80)
    {
        $conn = curl_init();
        curl_setopt($conn, CURLOPT_URL, $path);
        curl_setopt($conn, CURLOPT_PORT, $port);
        curl_setopt($conn, CURLOPT_TIMEOUT, 30);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($conn, CURLOPT_FORBID_REUSE, 1);

        if (!empty($params) && count($params) > 0)
            curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($params));
        else
            curl_setopt($conn, CURLOPT_POSTFIELDS, null);

        $data = $this->validateData(curl_exec($conn));
        curl_close($conn);

        return $data;
    }

    /**
     * @param $response
     * @return mixed
     * @throws Exception
     */
    private function validateData($response)
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