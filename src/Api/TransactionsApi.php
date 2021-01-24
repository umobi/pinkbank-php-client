<?php


namespace PinBank\Api;


use PinBank\Requests\EfetuarTransacaoRequest;
use PinBank\Requests\EfetuarTransacaoSplitRequest;
use PinBank\Requests\IncluirCartaoSingleRequest;
use PinBank\Responses\CancelResponse;
use PinBank\Responses\CaptureResponse;
use PinBank\Responses\CardResponse;
use PinBank\Responses\TransactionResponse;

class TransactionsApi extends BaseApi
{

    public function efetuarTransacaoEncrypted(EfetuarTransacaoRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/EfetuarTransacaoEncrypted", $payload);
        return new TransactionResponse($response);
    }

    public function capturarTransacaoEncrypted($nsu, $valor)
    {
        $payload = [
            "Data" => [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
                "Valor" => $valor,
                "NsuOperacao" => $nsu,
            ]
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/CapturarTransacaoEncrypted", $payload);
        return new CaptureResponse($response);
    }

    public function cancelarTransacaoEncrypted($nsu, $valor)
    {

        $payload = [
            "Data" => [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
                "Valor" => $valor,
                "NsuOperacao" => $nsu,
            ]
        ];
        $response = $this->sendRequest("POST", "api/Transacoes/CancelarTransacaoEncrypted", $payload);
        return new CancelResponse($response);
    }


    public function efetuarTransacaoSplitEncrypted(EfetuarTransacaoSplitRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/EfetuarTransacaoSplitEncrypted", $payload);
        return new TransactionResponse($response);
    }



    public function incluirCartaoEncrypted(IncluirCartaoSingleRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/IncluirCartaoEncrypted", $payload);
        return new CardResponse($response);
    }
}