<?php namespace TourChannel\Payments\Service;

/**
 * Classe para as métodos de pagamento que deve passar os serviços junto
 * Class ShopCart
 * @package TourChannel\Payments\Service
 */
abstract class ShopCart
{
    /**
     * Acesso ao payload da classe
     * @var array
     */
    protected $payload = [];

    /**
     * Função que adiciona o item junto ao payload
     * @param string $description
     * @param float $amount
     */
    public function addItem(string $description, float $amount)
    {
        $this->payload['items'][] = [
            'amount' => $amount,
            'description' => $description
        ];
    }
}