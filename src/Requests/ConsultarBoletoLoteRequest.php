<?php


namespace PinBank\Requests;


class ConsultarBoletoLoteRequest implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}