<?php


namespace PinBank\Responses;


class CancelResponse
{
    public $resultCode;
    public $message;
    public $validationData;
    public $cancelAuhorizationCode;

    public function __construct($response)
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
        $this->cancelAuhorizationCode = $response->Data->Data->CodigoAutorizacaoCancelamento ?? $response->Data->CodigoAutorizacaoCancelamento;
    }
}