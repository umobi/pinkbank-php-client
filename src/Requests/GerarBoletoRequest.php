<?php


namespace PinBank\Requests;


class GerarBoletoRequest implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}