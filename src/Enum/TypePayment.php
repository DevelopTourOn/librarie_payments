<?php namespace TourChannel\Payments\Enum;

/**
 * Tipos de pagamentos
 * Class TypePayment
 * @package TourChannel\Payments
 */
abstract class TypePayment
{
    /**
     * Método de pagamento em boleto
     */
    const BOLETO = 'ticket';

    /**
     * Método de pagamento em cartão de crédito
     */
    const CARTAO_CREDITO = 'card';

    /**
     * Método de pagamento em dois cartões
     */
    const DOIS_CARTOES = 'two_cards';

    /**
     * Método de pagamento em cartão de débito
     */
    const CARTAO_DEBITO = 'debit_card';
}