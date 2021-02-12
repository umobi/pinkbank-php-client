<?php


namespace PinBank\Requests;


class EfetuarTransacaoRequest implements \JsonSerializable
{
    public string $NomeImpresso;
    public string $DataValidade;
    public string $NumeroCartao;
    public string $CodigoSeguranca;

    /**
     * Valor da transação  Ex: R$ 1,00 => 100
     */
    public $Valor;

    /**
     * 1 => A Vista
     * 2 => Parcelado sem juros
     * 3 => Parcelado com juros
     */
    public int $FormaPagamento = 1;

    public int $QuantidadeParcelas = 1;

    public string $DescricaoPedido;

    public ?string $IpAddressComprador = null;

    public string $CpfComprador;

    public string $NomeComprador;

    /**
     *  True  => A autorização da transação não é efetivada no momento da requisição, sendo necessário capturar a transação posteriormente   Endpoint: /api/Transacoes/CapturarTransacao
     *  False => Efetiva a autorização da transação no momento da requisição Efetiva a autorização da transação no momento da requisição
     */
    public bool $TransacaoPreAutorizada;

    public function __construct(
        $holderName, $cardNumber, $validDate, $cvv, $value, $clientName, $clientDocument,
        $capture = false, $description = null, $paymentMethod = null, $parcels = null, $ip = null)
    {
        $this->NomeImpresso = $holderName;
        $this->NumeroCartao = $cardNumber;
        $this->DataValidade = $validDate;
        $this->CodigoSeguranca = $cvv;

        $this->Valor = $value;

        $this->NomeComprador = $clientName;
        $this->CpfComprador = $clientDocument;

        $this->TransacaoPreAutorizada = !$capture;

        $this->DescricaoPedido = $description ?? "";
        $this->FormaPagamento = $paymentMethod ?? 1;
        $this->QuantidadeParcelas = $parcels ?? 1;
        $this->IpAddressComprador = $ip ?? $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}