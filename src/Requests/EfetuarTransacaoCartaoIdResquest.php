<?php


namespace PinBank\Requests;


class EfetuarTransacaoCartaoIdResquest implements \JsonSerializable
{

    public $CodigoCanal;
    public $CodigoCliente;
    public $KeyLoja;
    public $CartaoId;
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