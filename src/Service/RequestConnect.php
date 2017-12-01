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
     * @param array $data
     * @return mixed|object
     */
    public function authenticate_api($path, $method, array $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_URL => self::URL_BASE_API . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json"
            ]
        ]);

        $response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $error_curl = curl_error($curl);

        curl_close($curl);

        return $this->response($response, $http_status, $error_curl);
    }

    /**
     * CURL para requisições na API depois que já possui o token
     * @param $path
     * @param $method
     * @param array $data
     * @return mixed|object
     */
    public function connect_api($path, $method, array $data)
    {
        $token_api = Authentication::getToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_URL => self::URL_BASE_API . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json",
                "api-token: $token_api"
            ]
        ]);

        $response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $error_curl = curl_error($curl);

        curl_close($curl);

        return $this->response($response, $http_status, $error_curl);
    }

    /**
     * Trata o retorno da API
     * @param $response
     * @param $http_status
     * @param $error_curl
     * @return mixed|object
     */
    private function response($response, $http_status, $error_curl) {

        if($http_status != 200) {

            $response = json_decode($response);

            $error_curl = (isset($response->message)) ? $response->message : $error_curl;

            return (object) [
                'status' => "error",
                'message' => "Falha na comunicação com a central de pagamentos: $error_curl"
            ];
        }

        return json_decode($response);
    }
}