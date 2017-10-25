<?php namespace TourChannel\Payments;

use TourChannel\Payments\PaymentMethods\CreditCard;
use TourChannel\Payments\PaymentMethods\DebitCard;
use TourChannel\Payments\PaymentMethods\Ticket;
use TourChannel\Payments\PaymentMethods\TwoCards;

/**
 * Classe para os métodos de pagamento
 * Class TourChannelPayments
 * @package TourChannel\Payments
 */
class TourChannelPayments
{
    /**
     * Pagamento com cartão
     * @return CreditCard
     */
    public function credit_card()
    {
        return new CreditCard();
    }

    /**
     * Pagamento com boleto bancário
     * @return Ticket
     */
    public function ticket()
    {
        return new Ticket();
    }

    /**
     * Pagamento em dois cartões
     * @return TwoCards
     */
    public function two_cards()
    {
        return new TwoCards();
    }

    /**
     * Pagamento com cartão de débito
     * @return DebitCard
     */
    public function debit_card()
    {
        return new DebitCard();
    }
}