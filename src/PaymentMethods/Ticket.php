<?php namespace TourChannel\Payments\PaymentMethods;

use Illuminate\Http\Request;
use TourChannel\Payments\Enum\StatusTransactionEnum;
use TourChannel\Payments\Service\RequestConnect;

/**
 * Método de pagamento via Boleto
 * Class Ticket
 * @package TourChannel\Payments\PaymentMethods
 */
class Ticket
{
    /** PATH da URl na API */
    const _PATH = '/pay/ticket';

    /** Quantidade de dias para vencimento do boleto */
    const daysDue = 2;

    /**
     * Formatado do array que ira para API
     * @var array
     */
    protected $payload = [
        'order' => '',
        'amount' => 0,
        'customer' => [
            'name' => '',
            'email' => '',
            'address' => [
                'street' => '',
                'number' => '',
                'zipCode' => '',
                'neighborhood' => '',
                'city' => '',
                'state' => ''
            ]
        ]
    ];

    /**
     * Numero do pedido
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->payload['order'] = $order;

        return $this;
    }

    /**
     * Valor da compra em centavos
     * @param $valor
     * @return $this
     */
    public function setAmount($valor)
    {
        $this->payload['amount'] = $valor;

        return $this;
    }

    /**
     * Nome do cliente que ira o boleto
     * @param $name_customer
     * @return $this
     */
    public function setCustomerName($name_customer)
    {
        $this->payload['customer']['name'] = $name_customer;

        return $this;
    }

    /**
     * E-mail do cliente para o boleto
     * @param $email_customer
     * @return $this
     */
    public function setCustomerEmail($email_customer)
    {
        $this->payload['customer']['email'] = $email_customer;

        return $this;
    }

    /**
     * Endereço para boleto registrado
     * @param $endereco
     * @return $this
     */
    public function setAddressStreet($endereco)
    {
        $this->payload['customer']['address']['street'] = $endereco;

        return $this;
    }

    /**
     * Número do endereço do cliente
     * @param $numero_address
     * @return $this
     */
    public function setAddressNumber($numero_address)
    {
        $this->payload['customer']['address']['number'] = $numero_address;

        return $this;
    }

    /**
     * CEP do endereço do cliente
     * @param $zip_code
     * @return $this
     */
    public function setAddressZipCode($zip_code)
    {
        $this->payload['customer']['address']['zipCode'] = str_replace( '-', '', $zip_code);

        return $this;
    }

    /**
     * Bairro do endereço do cliente
     * @param $bairro
     * @return $this
     */
    public function setAddressNeighborhood($bairro)
    {
        $this->payload['customer']['address']['neighborhood'] = $bairro;

        return $this;
    }

    /**
     * Cidade do cliente
     * @param $cidade
     * @return $this
     */
    public function setAddressCity($cidade)
    {
        $this->payload['customer']['address']['city'] = $cidade;

        return $this;
    }

    /**
     * Estado do cliente
     * @param $estado
     * @return $this
     */
    public function setAddressState($estado)
    {
        $this->payload['customer']['address']['state'] = $estado;

        return $this;
    }

    /**
     * Gera o boleto com a central de pagamentos
     * @return array
     */
    public function pay()
    {
        // Realiza a transação
        $response_api = $this->generateTicket();

        // Verifica se deu certo
        if($response_api->status == StatusTransactionEnum::PAGO) {
            return [
                'approved' => true,
                'transaction_id' => $response_api->transactionId,
                'barcode' => $response_api->barcode,
                'boleto_url' => $response_api->url
            ];
        }

        // Caso falhe a transação
        return [
            'approved' => false,
            'erro' => $response_api->message ?? "Não foi possível gerar o boleto, tente novamente!"
        ];
    }

    /**
     * Comunica com a API para gerar o boleto
     * @return mixed|string
     */
    private function generateTicket() {

        // Connect da API de pagamentos
        $request_connect = new RequestConnect();

        // Realiza a comunicação
        return $request_connect->connect_api(self::_PATH, Request::METHOD_POST, $this->payload);
    }
}