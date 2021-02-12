<?php


namespace PinBank\Requests;


class SolicitarEcommerceQrCodeRequest implements \JsonSerializable
{
    public $Valor;
    public $WebHookPagament;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}