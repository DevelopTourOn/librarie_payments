<?php namespace TourChannel\Payments\Traits;

use Symfony\Component\HttpFoundation\Request;
use TourChannel\Payments\Service\RequestConnect;

/**
 * Trait PaymentInquiry
 * @package TourChannel\Payments\Traits
 */
trait PaymentInquiry
{
    /**
     * URL para pesquisa na API
     * @string
     */
    private $PATH = "/payment/{id}";

    /**
     * Consulta as informações do pagamento na API
     * @param $transaction_id
     * @return mixed|string
     */
    public function transactionDetail($transaction_id)
    {
        $this->PATH = str_replace("{id}", $transaction_id, $this->PATH);

        return $this->request_api();
    }

    /**
     * CONSULTA API
     * @return mixed|string
     */
    private function request_api() {

        $tourchannel_payments = new RequestConnect();

        return $tourchannel_payments->connect_api($this->PATH, Request::METHOD_GET, []);
    }
}