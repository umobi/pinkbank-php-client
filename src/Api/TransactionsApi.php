<?php


namespace PinBank\Api;


use PinBank\Requests\EfetuarTransacaoCartaoIdResquest;
use PinBank\Requests\EfetuarTransacaoRequest;
use PinBank\Requests\EfetuarTransacaoSplitRequest;
use PinBank\Requests\IncluirCartaoSingleRequest;
use PinBank\Responses\CancelResponse;
use PinBank\Responses\CaptureResponse;
use PinBank\Responses\CardResponse;
use PinBank\Responses\StatusResponse;
use PinBank\Responses\TransactionResponse;

class TransactionsApi extends BaseApi
{

    public function efetuarTransacao(EfetuarTransacaoRequest $request)
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

    public function efetuarTransacaoCartaoId(EfetuarTransacaoCartaoIdResquest $request)
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

    public function capturarTransacao($nsu, $valor)
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

    public function cancelarTransacao($nsu, $valor)
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


    public function efetuarTransacaoSplit(EfetuarTransacaoSplitRequest $request)
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

    public function excluirCartao( $cardId )
    {
        $payload = [
            "Data" => [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "CartaoId" => $cardId,
            ]
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/ExcluirCartaoEncrypted", $payload);
        return new StatusResponse($response);
    }

    public function cancelarTransacaoSplit($nsu, $valor)
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
        $response = $this->sendRequest("POST", "api/Transacoes/CancelarTransacaoSplitEncrypted", $payload);
        return new CancelResponse($response);
    }



    public function incluirCartao(IncluirCartaoSingleRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/IncluirCartaoEncrypted", $payload);
        return new CardResponse($response, $payload['Data']);
    }



    public function ativarCartao($cardId, $value)
    {
        $payload = [
            "Data" => [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "CartaoId" => $cardId,
                "ProtocoloAtivacao" => $value
            ]
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/AtivarCartaoEncrypted", $payload);
        return new StatusResponse($response);
    }

    public function consultarDadosCartao( $cardId )
    {
        $payload = [
            "Data" => [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "CartaoId" => $cardId,
            ]
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/ConsultarDadosCartaoEncrypted", $payload);
        return new CardResponse($response);
    }
}