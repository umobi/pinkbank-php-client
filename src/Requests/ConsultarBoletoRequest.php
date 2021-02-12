<?php


namespace PinBank\Requests;


class ConsultarBoletoRequest implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}