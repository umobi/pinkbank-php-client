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

    public function testNewTransaction()
    {
        $request = new EfetuarTransacaoRequest(
            "Fulano de Tal",
            "4242424242424242",
            "201912",
            "123",
            100,
            "Ramon Vicente",
            "02466862190"
        );

        $result = $this->client->efetuarTransacao($request);
        $this->assertInstanceOf(TransactionResponse::class, $result);
    }

    public function testCaptureTransaction()
    {
        $request = new EfetuarTransacaoRequest(
            "Fulano de Tal",
            "4242424242424242",
            "201912",
            "123",
            100,
            "Ramon Vicente",
            "02466862190"
        );

        $result = $this->client->efetuarTransacao($request);

        $result = $this->client->capturarTransacao($result->nsu, 100);
        $this->assertInstanceOf(CaptureResponse::class, $result);
    }

    public function testCancelTransaction()
    {
        $request = new EfetuarTransacaoRequest(
            "Fulano de Tal",
            "4242424242424242",
            "201912",
            "123",
            100,
            "Ramon Vicente",
            "02466862190"
        );

        $result = $this->client->efetuarTransacao($request);

        $result = $this->client->cancelarTransacao($result->nsu, 100);
        $this->assertInstanceOf(CancelResponse::class, $result);
    }

    public function testQueryTransactions()
    {
        $request = new ExtratoPosRequest('2020-10-01', '2020-10-01');
        $result = $this->client->extratoPos($request, 109207, 80);

        $this->assertInstanceOf(ExtratoPosResponse::class, $result);
    }

    public function testNewTransactionSplit()
    {
        $request = new EfetuarTransacaoSplitRequest(
            "Fulano de Tal",
            "4242424242424242",
            "201912",
            "123",
            100,
            "Ramon Vicente",
            "02466862190",
            [[
                'CodigoCliente' => 7309,
                'Valor' => 40
            ]]
        );

        $result = $this->client->efetuarTransacaoSplit($request);
        $this->assertInstanceOf(TransactionResponse::class, $result);
    }

    public function testCreateCard()
    {
        $request = new IncluirCartaoSingleRequest("4141414141414146", "Fulano de Tal", "202112", "123", true);
        $result = $this->client->incluirCartao($request);

        $this->assertInstanceOf(CardResponse::class, $result);
    }

    public function testQueryCard()
    {
        $request = new IncluirCartaoSingleRequest("4141414141414146", "Fulano de Tal", "202112", "123", true);
        $result = $this->client->incluirCartao($request);

        $result = $this->client->consultarDadosCartao($result->cardId);
        $this->assertInstanceOf(CardResponse::class, $result);
    }
}