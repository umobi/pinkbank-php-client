<?php


namespace PinBank\Requests;


class EfetuarTransacaoSplitRequest extends EfetuarTransacaoRequest
{
    public array $Split;

    public function __construct($holderName, $cardNumber, $validDate, $cvv, $value, $clientName, $clientDocument,
                                $split, $capture = false, $description = null,
                                $paymentMethod = null, $parcels = null, $ip = null)
    {
        parent::__construct($holderName, $cardNumber, $validDate, $cvv, $value, $clientName, $clientDocument,
            $capture, $description, $paymentMethod, $parcels, $ip);
        $this->Split = $split;
    }
}