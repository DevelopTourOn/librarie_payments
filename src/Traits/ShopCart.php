<?php namespace TourChannel\Payments\Traits;

/**
 * Lista de serviço comprados junto com a compra
 * Trait ShopCart
 * @package TourChannel\Payments\Service
 */
trait ShopCart
{
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