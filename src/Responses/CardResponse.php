<?php


namespace PinBank\Responses;


class CardResponse
{
    public $resultCode;
    public $message;
    public $validationData;
    public $cardId;

    public function __construct($response)
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
        $this->cardId = $response->Data->Data->CartaoId ?? $response->Data->CartaoId;
    }
}