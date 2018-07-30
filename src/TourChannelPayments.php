<?php namespace TourChannel\Payments;

use TourChannel\Payments\PaymentMethods\CreditCard;
use TourChannel\Payments\PaymentMethods\DebitCard;
use TourChannel\Payments\PaymentMethods\Ticket;
use TourChannel\Payments\PaymentMethods\TwoCards;
use TourChannel\Payments\Traits\PaymentInquiry;

use TourChannel\Payments\Service\Authentication;
use TourChannel\Payments\Service\RequestConnect;
use Symfony\Component\HttpFoundation\Request;
/**
 * Classe para os métodos de pagamento
 * Class TourChannelPayments
 * @package TourChannel\Payments
 */
class TourChannelPayments
{
    use PaymentInquiry;


    public function __construct(string $user = "", string $password = "")
    {
        Authentication::setUser($user);
        Authentication::setPassword($password);

    }

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
