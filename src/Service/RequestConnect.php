<?php namespace TourChannel\Payments\Service;

/**
 * Class RequestConnect
 * @package TourChannel\Payments\Service
 */
class RequestConnect
{
    /**
     * Url base da API de pagamentos
     */
    const URL_BASE_API = 'https://pagamentos.tourchannel.com.br/api/v1';

    /**
     * Curl para autenticação na API
     * @param $path
     * @param $method
     * @param $data
     * @return mixed|string
     */
    public function authenticate_api($path, $method, array $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL_BASE_API . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json"
            ]
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    /**
     * CURL para requisições na API depois que já possui o token
     * @param $path
     * @param $method
     * @param array $data
     * @return mixed|string
     */
    public function connect_api($path, $method, array $data)
    {
        $token_api = Authentication::getToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL_BASE_API . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json",
                "api-token: $token_api"
            ]
        ]);

        $response = curl_exec($curl);

        return json_decode($response);
    }
}