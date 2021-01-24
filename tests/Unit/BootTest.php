<?php

namespace PinBank\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PinBank\Api\ContaDigitalApi;
use PinBank\Api\TransactionsApi;
use PinBank\Configuration;
use PinBank\PinBank;
use PinBank\Requests\EfetuarTransacaoRequest;
use PinBank\Requests\EfetuarTransacaoSplitRequest;
use PinBank\Requests\ExtratoPosRequest;
use PinBank\Requests\IncluirCartaoSingleRequest;
use PinBank\Responses\CancelResponse;
use PinBank\Responses\CaptureResponse;
use PinBank\Responses\CardResponse;
use PinBank\Responses\ExtratoPosResponse;
use PinBank\Responses\TransactionResponse;

class BootTest extends TestCase
{

    /** @var PinBank|TransactionsApi|ContaDigitalApi $client */
    protected $client;

    protected function setUp(): void
    {
        $config = new Configuration("808nDpIUUEhY",
            "p2RC68H71mrAWON5", 5, 47, 3510,
            '11384322623341877660', true);

        $this->client = new PinBank($config);
    }

    public function testNewClient()
    {
        $this->assertInstanceOf(PinBank::class, $this->client);
    }

    public function testExtratoPos()
    {
        $request = new ExtratoPosRequest();

        $result = $this->client->extratoPosEncrypted($request);

        $this->assertInstanceOf(ExtratoPosResponse::class, $result);
    }

    public function testNewTransactionSplit()
    {


        $request = new EfetuarTransacaoSplitRequest();

        $request->NomeImpresso = "Fulano de Tal";
        $request->DataValidade = "201912";
        $request->NumeroCartao = "4242424242424242";
        $request->CodigoSeguranca = "123";
        $request->Valor = 100;
        $request->FormaPagamento = 1;
        $request->QuantidadeParcelas = 1;
        $request->DescricaoPedido = "Pedido Teste Desc";
        $request->CpfComprador = "02466862190";
        $request->NomeComprador = "Ramon Vicente";
        $request->TransacaoPreAutorizada = true;
        $request->Split = [[
            'CodigoCliente' => 3510,
            'CodigoCanal' => 47,
            'Valor' => 100
        ]];

        $result = $this->client->efetuarTransacaoSplitEncrypted($request);
        $this->assertInstanceOf(TransactionResponse::class, $result);
    }

    public function testNewTransaction()
    {


        $request = new EfetuarTransacaoRequest();

        $request->NomeImpresso = "Fulano de Tal";
        $request->DataValidade = "201912";
        $request->NumeroCartao = "4242424242424242";
        $request->CodigoSeguranca = "123";
        $request->Valor = 100;
        $request->FormaPagamento = 1;
        $request->QuantidadeParcelas = 1;
        $request->DescricaoPedido = "Pedido Teste Desc";
        $request->CpfComprador = "02466862190";
        $request->NomeComprador = "Ramon Vicente";
        $request->TransacaoPreAutorizada = true;

        $result = $this->client->efetuarTransacaoEncrypted($request);
        $this->assertInstanceOf(TransactionResponse::class, $result);
    }

    public function disabletestCaptureTransaction()
    {
        $result = $this->client->capturarTransacaoEncrypted("20029816", 100);
        $this->assertInstanceOf(CaptureResponse::class, $result);
    }

    public function disabletestCancelTransaction()
    {
        $result = $this->client->cancelarTransacaoEncrypted("20029816", 100);
        $this->assertInstanceOf(CancelResponse::class, $result);
    }

    public function disabletestCreateCard()
    {
        $request = new IncluirCartaoSingleRequest("4141414141414145", "Fulano de Tal", "202112", "123", true);
        $result = $this->client->incluirCartaoEncrypted($request);
        $this->assertInstanceOf(CardResponse::class, $result);
    }
}