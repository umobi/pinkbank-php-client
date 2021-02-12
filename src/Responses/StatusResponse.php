<?php


namespace PinBank\Responses;


class StatusResponse
{
    public $resultCode;
    public $message;
    public $validationData;

    public function __construct($response)
    {
        $this->resultCode = $response->ResultCode;
        $this->message = $response->Message;
        $this->validationData = $response->ValidationData;
    }
}