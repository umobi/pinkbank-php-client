<?php


namespace PinBank\Responses;


class CardResponse
{
    public $resultCode;
    public $message;
    public $validationData;
    public $cardId;

    private $alias;
    private $brand;
    private $holder;
    private $number;
    private $expireDate;
    private $status;


    public function __construct($response, $payload = [])
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
        $this->cardId = $response->Data->Data->CartaoId ?? $response->Data->CartaoId;

        $this->alias = $response->Data->Data->Apelido ?? $response->Data->Apelido ?? $payload['Apelido'] ?? null;
        $this->brand = $response->Data->Data->Bandeira ?? $response->Data->Bandeira ?? $payload['Bandeira'] ?? null;
        $this->holder = $response->Data->Data->NomeImpresso ?? $response->Data->NomeImpresso ?? $payload['NomeImpresso'] ?? null;
        $this->number = $response->Data->Data->NumeroCartao ?? $response->Data->NumeroCartao ?? $payload['NumeroCartao'] ?? null;
        $this->expireDate = $response->Data->Data->DataValidade ?? $response->Data->DataValidade ?? $payload['DataValidade'] ?? null;
        $this->status = $response->Data->Data->Status ?? $response->Data->Status ?? $payload['Status'] ?? null;
    }
}