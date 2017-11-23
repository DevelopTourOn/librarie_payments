<?php namespace TourChannel\Payments\Enum;

/**
 * Tipos de eventos enviados pela API
 * Class EventTypeEnum
 * @package TourChannel\Payments\Enum
 */
class EventTypeEnum
{
    /** Notificação de quando o boleto foi pago */
    const BOLETO_PAGO = "ticket_paid ";

    /** Notificação de quando o boleto foi cancelado */
    const BOLETO_CANCELADO = "canceled_ticket";

    /** Notificação de quando o boleto está prestes a vencer */
    const BOLETO_QUASE_VENCENDO = "ticket_expiration";

    /** Notificação de quando o boleto foi pago a maior */
    const BOLETO_PAGO_MAIOR = "ticket_overpaid";

    /** Notificação de quando o boleto foi pago a menor */
    const BOLETO_PAGO_MENOR = "ticket_underpaid";
}