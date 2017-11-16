<?php namespace TourChannel\Payments\Enum;

/**
 * Class StatusTransactionEnum
 * @package TourChannel\Payments\Enum
 */
abstract class StatusTransactionEnum
{
    const PAGO = "pay";

    const PENDENTE = "pending";

    const FAILED = "failed";

    const CANCELADO = "cancelled";

    const PROCESSANDO = "processing";
}