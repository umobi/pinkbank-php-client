<?php /** @noinspection PhpMissingFieldTypeInspection */


namespace PinBank\Responses;

class TransactionResponse
{
    public $resultCode;
    public $message;
    public $validationData;
    public $authorizationCode;
    public $nsu;

    public function __construct($response)
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
        $this->authorizationCode = $response->Data->Data->CodigoAutorizacao ?? $response->Data->CodigoAutorizacao;
        $this->nsu = $response->Data->Data->NsuOperacao ?? $response->Data->NsuOperacao;
    }
}