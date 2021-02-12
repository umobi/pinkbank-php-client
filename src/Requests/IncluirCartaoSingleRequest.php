<?php


namespace PinBank\Requests;


class IncluirCartaoSingleRequest implements \JsonSerializable
{
    private string $Apelido;
    private string $NomeImpresso;
    private string $NumeroCartao;
    private string $DataValidade;
    private string $CodigoSeguranca;
    private bool $ValidarCartao;


    public function __construct($number, $holder, $expireDate, $cvv, $validateCard = false, $alias = null)
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