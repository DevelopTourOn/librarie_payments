<?php namespace TourChannel\Payments;

use TourChannel\Payments\PaymentMethods\CreditCard;

/**
 * Classe para os métodos de pagamento
 * Class TourChannelPayments
 * @package TourChannel\Payments
 */
class TourChannelPayments
{
    public function credit_card()
    {
        return new CreditCard();
    }
}