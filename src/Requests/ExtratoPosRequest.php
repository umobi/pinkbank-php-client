<?php


namespace PinBank\Requests;


class ExtratoPosRequest
{
    public $DataInicial;
    public $DataFinal;
    public $Status;
    public $MeioCaptura;
    public $IdTerminalPos;
    public $QuantidadeLinhasRetorno;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}