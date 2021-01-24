<?php


namespace PinBank\Responses;


class CaptureResponse
{
    public $resultCode;
    public $message;
    public $validationData;
    public $captureAuhorizationCode;

    public function __construct($response)
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
        $this->captureAuhorizationCode = $response->Data->Data->CodigoAutorizacaoCaptura ?? $response->Data->CodigoAutorizacaoCaptura;
    }
}