<?php


namespace PinBank\Requests;


class IncluirCartaoSingleRequest implements \JsonSerializable
{
    private $Apelido;
    private $NomeImpresso;
    private $NumeroCartao;
    private $DataValidade;
    private $CodigoSeguranca;
    private $ValidarCartao;


    public function __construct($number, $holder, $expireDate, $cvv, $validateCard = true, $alias = null)
    {

        $this->NomeImpresso = $holder;
        $this->NumeroCartao = $number;
        $this->DataValidade = $expireDate;
        $this->CodigoSeguranca = $cvv;
        $this->ValidarCartao = !!$validateCard;

        if (isset($alias) && !empty($alias)) {
            $this->Apelido = $alias;
        } else {
            $this->Apelido = time() . uniqid();
        }
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}