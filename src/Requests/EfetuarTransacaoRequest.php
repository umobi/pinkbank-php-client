<?php


namespace PinBank\Requests;


class EfetuarTransacaoRequest implements \JsonSerializable
{
    public $NomeImpresso;
    public $DataValidade;
    public $NumeroCartao;
    public $CodigoSeguranca;
    public $Valor;
    public $FormaPagamento;
    public $QuantidadeParcelas;
    public $DescricaoPedido;
    public $IpAddressComprador;
    public $CpfComprador;
    public $NomeComprador;
    public $TransacaoPreAutorizada;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}